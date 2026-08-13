const CACHE='jina-reader-v1';
const ASSETS=['./','./index.html','./styles.css','./icon.svg','./manifest.json'];

self.addEventListener('install',e=>{
  e.waitUntil(caches.open(CACHE).then(c=>c.addAll(ASSETS)).then(()=>self.skipWaiting()));
});
self.addEventListener('activate',e=>{
  e.waitUntil(
    caches.keys()
      .then(keys=>Promise.all(keys.filter(k=>k!==CACHE).map(k=>caches.delete(k))))
      .then(()=>self.clients.claim())
  );
});
self.addEventListener('fetch',e=>{
  const req=e.request;
  if(req.method!=='GET')return;
  const url=new URL(req.url);

  if(url.origin==='https://r.jina.ai'){
    e.respondWith(
      fetch(req).then(res=>{
        const clone=res.clone();
        caches.open(CACHE).then(c=>c.put(req,clone));
        return res;
      }).catch(()=>caches.match(req))
    );
    return;
  }

  e.respondWith(
    caches.match(req).then(cached=>{
      const fresh=fetch(req).then(res=>{
        caches.open(CACHE).then(c=>c.put(req,res.clone()));
        return res;
      }).catch(()=>cached);
      return cached||fresh;
    })
  );
});