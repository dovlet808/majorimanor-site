# Leaflet 1.9.4 — self-hosted

Served from this directory and from nowhere else. No CDN: the client is in the
EU, a CDN request is a third-party request, and `unpkg.com` going down must not
take a map with it.

```
leaflet.js     1.9.4, the published minified build, unmodified
leaflet.css    1.9.4, unmodified
images/        the library's own sprites, referenced by leaflet.css
```

The files are copied verbatim from the same 1.9.4 build the GP IMPEX site runs.
Nothing in them is patched — the site's own map styling lives in
`assets/css/main.css` under `.c-map`, and the marker is a `divIcon` styled
there, which is why none of `images/` is fetched in practice. They are kept so
that the stylesheet is not referring to files that are not next to it.

Neither file is loaded until a reader scrolls to the map: see the map module in
`assets/js/main.js`, and `templates/components/map.php` for the placeholder
that stands in the meantime.

Upgrading: replace the three items with the same three from the next release,
check the map still opens on /contact, and check the attribution control still
reads CARTO / OpenStreetMap / Leaflet.
