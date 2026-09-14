/**
 * Measure the contrast of every text element on a film page, at one width.
 *
 *     npm i puppeteer-core            # once; the repo carries no node_modules
 *     SP=. node tools/measure_contrast.js http://127.0.0.1:8321/events 1440 900 22
 *
 * It scrolls the page with real wheel events so Lenis moves it exactly as a
 * reader does, and at each stop it takes the 95th-percentile brightest
 * background pixel each element's LETTERS cross and reports the worst ratio
 * that element reaches anywhere on the page.
 *
 * THREE THINGS ABOUT THE METHOD, AND ALL THREE WERE BUGS FIRST. Each of them
 * produced a "failure" on a page that was fine, and each would have been fixed
 * by darkening a picture that did not need it. docs/EVENTS.md §10 tells the
 * story; the rules are:
 *
 *   1. NO clip ON THE SCREENSHOT. page.screenshot({clip}) clips in DOCUMENT
 *      coordinates, not viewport coordinates, so every sample after the first
 *      screen is taken against the top of the page.
 *
 *   2. TRANSPARENT GLYPHS, NOT visibility: hidden. Hiding an element takes its
 *      own background and pseudo-elements with it — which is exactly what a
 *      legibility fix that puts something BEHIND the type is made of. A gold
 *      button measured this way reports 1.1 instead of 9.
 *
 *   3. Range.getClientRects(), NOT getBoundingClientRect(). The border box of a
 *      centred <p> is the column; the letters are a fifth of it. Sampling the
 *      box measures a picture the type never crosses.
 *
 * The colour of each element is stashed on a data- attribute BEFORE the
 * override is applied, or getComputedStyle reports the override.
 *
 * A LOCAL HARNESS ONLY. Nothing under public_html/ knows it exists.
 */
const puppeteer = require(process.env.SP + '/node_modules/puppeteer-core');

const SEL = [
 '.c-film-hero__eyebrow','.c-film-hero__title','.c-film-hero__statement','.c-film-hero__cue span',
 '.c-film-nav__mark-name','.c-film-nav__links a','.c-film-nav__action',
 '.c-film-band__index','.c-film-band__eyebrow','.c-film-band__title','.c-film-band__caption',
 '.c-film-chapter__index','.c-film-chapter__eyebrow','.c-film-chapter__title','.c-film-chapter__lede','.c-film-chapter__body p',
 '.c-ledger__index','.c-ledger__eyebrow','.c-ledger__title','.c-ledger__label','.c-ledger__value','.c-ledger__note',
 '.c-film-plates__caption',
 // ADDED WITH AFTER DARK. The lateral track arrived with THE CLUB and the
 // standalone clause has only ever appeared on /after-dark; neither was in this
 // list, so three pages' detail captions and one page's legal line were being
 // swept past rather than measured. Both are text on a ground like everything
 // else above.
 '.c-detail__index','.c-detail__eyebrow','.c-detail__title','.c-detail__lede',
 '.c-detail__n','.c-detail__label','.c-detail__mark',
 '.c-clause p',
 '.c-dialogue__index','.c-dialogue__eyebrow','.c-dialogue__title','.c-dialogue__n','.c-dialogue__label','.c-dialogue__note',
 '.c-film-world__index','.c-film-world__eyebrow','.c-film-world__title','.c-film-world__n','.c-film-world__label','.c-film-world__note',
 '.c-film-invite__eyebrow','.c-film-invite__title','.c-film-invite__body','.c-film-invite__action',
 '.c-film-foot__tagline','.c-film-foot__place','.c-film-foot__links a','.c-film-foot__contact a','.c-film-foot__members',
 // ADDED WITH PRIVACY. The document is the first light ground this harness has
 // ever been pointed at — every page before it was cream type on a photograph,
 // and this one is near-black type on paper with a green panel beside it. The
 // method does not change: the sample is still the 95th-percentile BRIGHTEST
 // pixel the letters cross, which on a light ground is the paper itself and is
 // therefore still the worst case for dark ink.
 '.c-legal-index__label','.c-legal-index__updated','.c-legal-index__updated time',
 '.c-legal-index__n','.c-legal-index__title',
 '.c-legal-clause__index','.c-legal-clause__title','.c-legal-clause__body p',
 '.c-legal-clause__list li','.c-legal-clause a',
 '.c-legal-note__label','.c-legal-note__body',
 '.c-legal__updated','.c-legal__updated time','.c-legal__top',
 // ADDED WITH TERMS. Three elements /privacy has no equivalent of: the two
 // chapter breaks the brief for that page forbade and the brief for this one
 // asks for, and the mark in the contents that has to agree with them. The
 // field's label is cream on --green-900 and its numeral is gold on the same,
 // which is the index panel's own pair; the index's chapter mark is gold on
 // green. All three are small uppercase type, which is the size at which a
 // ratio has to be right rather than nearly right.
 '.c-legal-break__numeral','.c-legal-break__label',
 '.c-legal-index__chapter','.c-legal-index__chapter-n'
];
// THE TYPE IS MADE TRANSPARENT RATHER THAN HIDDEN. visibility:hidden takes the
// element's own background and pseudo-elements with it, which is exactly what
// two of the measured elements use to become legible: the gold fill under the
// invitation's button, and the wash events.css hangs behind the hero eyebrow.
// Transparent glyphs leave every painted layer where it is and remove only the
// letters, which is what the sample is supposed to be taken without.
const HIDE = SEL.join(',') + '{color:transparent !important;text-shadow:none !important;-webkit-text-fill-color:transparent !important}';

function srgb(c){ c/=255; return c<=0.03928 ? c/12.92 : Math.pow((c+0.055)/1.055, 2.4); }
function lum(r,g,b){ return 0.2126*srgb(r)+0.7152*srgb(g)+0.0722*srgb(b); }
function ratio(l1,l2){ const a=Math.max(l1,l2), b=Math.min(l1,l2); return (a+0.05)/(b+0.05); }

async function settle(page){
  let last=-1, same=0;
  for (let i=0;i<80 && same<4;i++){
    const y = await page.evaluate(()=>Math.round(window.scrollY));
    if (y===last) same++; else { same=0; last=y; }
    await new Promise(r=>setTimeout(r,60));
  }
  return last;
}

(async () => {
  const [url, w, h, samples] = process.argv.slice(2);
  const browser = await puppeteer.launch({executablePath:'/usr/bin/google-chrome',headless:'shell',
    args:['--no-sandbox','--disable-dev-shm-usage','--force-device-scale-factor=1','--autoplay-policy=no-user-gesture-required']});
  const page = await browser.newPage(); await page.setViewport({width:+w,height:+h});
  await page.goto(url,{waitUntil:'networkidle2',timeout:60000});
  await new Promise(r=>setTimeout(r,1600));
  // Stash every measured element's own colour BEFORE the glyphs are made
  // transparent — getComputedStyle would otherwise report the override.
  await page.evaluate((SEL)=>{
    for (const s of SEL) document.querySelectorAll(s).forEach(el=>{
      el.dataset.mmColor = getComputedStyle(el).color;
    });
  }, SEL);
  await page.addStyleTag({content: HIDE});   // transparent for the whole sweep
  const worst = new Map();
  let cur=0; const N=+samples;
  let measured = 0;
  for (let i=0;i<=N;i++){
    const total = await page.evaluate(()=>document.body.scrollHeight-innerHeight);
    const target = Math.round(total*i/N);
    let guard=0;
    while (cur < target-4 && guard++<800){ const step=Math.min(700,target-cur); await page.mouse.wheel({deltaY:step}); cur+=step; await new Promise(r=>setTimeout(r,20)); }
    await settle(page);
    // measure boxes and grab the frame with nothing moving in between
    const bs = await page.evaluate((SEL)=>{
      const out=[];
      for (const s of SEL) document.querySelectorAll(s).forEach(el=>{
        let op=1,n=el; while(n&&n!==document.documentElement){ op*=parseFloat(getComputedStyle(n).opacity||'1'); n=n.parentElement; }
        if (op<0.9) return;
        const cs=getComputedStyle(el);
        /*
           THE BOX IS THE TYPE AND NOT THE ELEMENT. A centred <p> inside the
           hero's copy column is 1325px wide and its text is 200 of them; taking
           the 95th-percentile brightest pixel of the whole block samples a
           picture the letters never cross. Range.getClientRects() gives the
           line boxes the glyphs actually occupy, which is what the sample is
           supposed to be taken over.
        */
        const range = document.createRange();
        range.selectNodeContents(el);
        for (const r of range.getClientRects()) {
          if (r.width<2||r.height<2) continue;
          if (r.top < 92 || r.bottom > innerHeight-2) continue;
          out.push({sel:s,x:Math.round(r.x),y:Math.round(r.y),w:Math.round(r.width),h:Math.round(r.height),
                    color:el.dataset.mmColor||cs.color,fs:parseFloat(cs.fontSize),fw:cs.fontWeight});
        }
      });
      return out;
    }, SEL);
    if (!bs.length) continue;
    const shot = await page.screenshot();
    const y2 = await page.evaluate(()=>Math.round(window.scrollY));
    const data = await page.evaluate(async (dataUrl, bs) => {
      const img=new Image(); await new Promise(r=>{img.onload=r; img.src=dataUrl;});
      const c=document.createElement('canvas'); c.width=img.width; c.height=img.height;
      const ctx=c.getContext('2d'); ctx.drawImage(img,0,0);
      return bs.map(b=>{
        const W=Math.min(b.w, c.width-Math.max(0,b.x)), H=Math.min(b.h, c.height-Math.max(0,b.y));
        if (W<1||H<1) return null;
        const d=ctx.getImageData(Math.max(0,b.x),Math.max(0,b.y),W,H).data;
        const L=[]; for(let p=0;p<d.length;p+=4) L.push([d[p],d[p+1],d[p+2]]);
        return L;
      });
    }, 'data:image/png;base64,'+Buffer.from(shot).toString('base64'), bs);
    bs.forEach((b,idx)=>{
      const pix=data[idx]; if(!pix||!pix.length) return;
      const lums=pix.map(p=>lum(p[0],p[1],p[2])).sort((a,z)=>a-z);
      const bgL=lums[Math.floor(lums.length*0.95)];
      const bgP=pix[0];
      const m=b.color.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/); if(!m) return;
      const fg=lum(+m[1],+m[2],+m[3]);
      const r=ratio(fg,bgL);
      const large = b.fs>=24 || (b.fs>=18.66 && +b.fw>=700);
      const prev=worst.get(b.sel);
      if (!prev || r<prev.r) worst.set(b.sel,{r:+r.toFixed(2),fs:b.fs,large,at:y2,bgL:+bgL.toFixed(4)});
      measured++;
    });
  }
  const rows=[...worst.entries()].map(([sel,v])=>({sel,...v})).sort((a,b)=>a.r-b.r);
  console.log(JSON.stringify({width:+w,height:+h,measured,rows},null,1));
  await browser.close();
})();
