(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const HOVER = matchMedia("(hover:hover)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;
  const clamp = (v, a, b) => Math.min(Math.max(v, a), b);

  /* ---------- page load ---------- */
  const ready = () => document.body.classList.add('ready');
  document.fonts?.ready ? (document.fonts.ready.then(ready), setTimeout(ready, 1300)) : ready();

  /* ---------- animated brand mesh (the moving gradient behind brand panels) ---------- */
  const meshes = [];
  const makeMesh = (cv) => {
    const ctx = cv.getContext('2d');
    // kept deliberately low-contrast — the mesh should read as a soft wash,
    // not a loud gradient competing with the headline
    const BLOBS = [
      { h: '#E85A1E', r: .82, sx: .00013, sy: .00010, ox: .26, oy: .32 },
      { h: '#C63B05', r: .78, sx: -.00010, sy: .00014, ox: .76, oy: .28 },
      { h: '#F0762F', r: .64, sx: .00016, sy: -.00011, ox: .60, oy: .74 },
      { h: '#B8350A', r: .70, sx: -.00013, sy: -.00009, ox: .20, oy: .78 },
      { h: '#DC4B0E', r: .56, sx: .00008, sy: .00015, ox: .50, oy: .52 }
    ];
    let w = 0, h = 0, dpr = 1, anim = null, t0 = performance.now();

    const size = () => {
      const r = cv.getBoundingClientRect();
      dpr = Math.min(devicePixelRatio || 1, 1.5);
      w = Math.max(r.width, 1); h = Math.max(r.height, 1);
      cv.width = w * dpr; cv.height = h * dpr;
      ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
    };
    const paint = (now) => {
      const t = now - t0;
      ctx.fillStyle = '#E04400';
      ctx.fillRect(0, 0, w, h);
      ctx.globalCompositeOperation = 'lighter';
      for (const b of BLOBS) {
        const x = (b.ox + Math.sin(t * b.sx) * .13) * w;
        const y = (b.oy + Math.cos(t * b.sy) * .13) * h;
        const rad = b.r * Math.max(w, h) * .62;
        const g = ctx.createRadialGradient(x, y, 0, x, y, rad);
        g.addColorStop(0, b.h + '6B');
        g.addColorStop(.55, b.h + '1E');
        g.addColorStop(1, b.h + '00');
        ctx.fillStyle = g;
        ctx.beginPath(); ctx.arc(x, y, rad, 0, Math.PI * 2); ctx.fill();
      }
      ctx.globalCompositeOperation = 'source-over';
    };
    const loop = (now) => { paint(now); anim = raf(loop); };
    const start = () => { if (!anim) { if (RM) paint(performance.now()); else anim = raf(loop); } };
    const stop = () => { cancelAnimationFrame(anim); anim = null; };

    size(); paint(performance.now());
    if (!RM) start();
    new IntersectionObserver(e => e[0].isIntersecting ? start() : stop(), { threshold: 0 }).observe(cv);
    meshes.push({ size, paint });
  };
  $$('.mesh').forEach(makeMesh);
  let mt; addEventListener('resize', () => {
    clearTimeout(mt);
    mt = setTimeout(() => meshes.forEach(m => { m.size(); m.paint(performance.now()); }), 180);
  });

  /* ---------- header: solid on scroll, inverts over dark/brand panels ---------- */
  {
    const hdr = $('#hdr'), prog = $('#prog'), top = $('#totop'), mcta = $('#mcta'), band = $('#ctaband');
    const darkish = $$('.panel--dark, .panel--brand, .hero, .price9');
    let bandVis = false, tick = false;
    if (band) new IntersectionObserver(e => { bandVis = e[0].isIntersecting; }, { threshold: .3 }).observe(band);

    const run = () => {
      const y = scrollY;
      hdr.classList.toggle('solid', y > 12);
      top.classList.toggle('on', y > 900);
      mcta.classList.toggle('on', y > 700 && !bandVis);
      const max = document.documentElement.scrollHeight - innerHeight;
      prog.style.width = (max > 0 ? (y / max) * 100 : 0) + '%';
      // invert when the header sits over a dark or brand panel
      const probe = hdr.getBoundingClientRect().bottom - 18;
      const over = darkish.some(p => { const r = p.getBoundingClientRect(); return r.top <= probe && r.bottom >= probe; });
      hdr.classList.toggle('inv', over);
      tick = false;
    };
    addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
    addEventListener('resize', run);
    run();
    top.addEventListener('click', () => scrollTo({ top: 0, behavior: RM ? 'auto' : 'smooth' }));
  }

  /* ---------- nav underline follows the section you're in ---------- */
  {
    const links = $$('#nav a[href^="#"]');
    const map = links.map(a => ({ a, s: $(a.getAttribute('href')) })).filter(o => o.s);
    if (map.length) {
      const seen = new Set();
      const pick = () => {
        links.forEach(l => l.classList.remove('on'));
        if (!seen.size) return;
        const mid = innerHeight / 2;
        let best = null, bd = Infinity;
        seen.forEach(s => {
          const r = s.getBoundingClientRect();
          const d = Math.abs((r.top + r.bottom) / 2 - mid);
          if (d < bd) { bd = d; best = s; }
        });
        map.find(o => o.s === best)?.a.classList.add('on');
      };
      const io = new IntersectionObserver(es => {
        es.forEach(e => e.isIntersecting ? seen.add(e.target) : seen.delete(e.target));
        pick();
      }, { rootMargin: '-40% 0px -45% 0px' });
      map.forEach(o => io.observe(o.s));
    }
  }

  /* ---------- mobile menu ---------- */
  {
    const b = $('#burger'), m = $('#mnav');
    const set = (o) => {
      m.classList.toggle('open', o); b.classList.toggle('open', o);
      b.setAttribute('aria-expanded', String(o));
      b.setAttribute('aria-label', o ? 'Close menu' : 'Open menu');
      document.body.style.overflow = o ? 'hidden' : '';
    };
    b.addEventListener('click', () => set(!m.classList.contains('open')));
    $$('#mnav a').forEach(a => a.addEventListener('click', () => set(false)));
    addEventListener('keydown', e => { if (e.key === 'Escape') set(false); });
  }

  /* ---------- reveals ---------- */
  if (RM || !('IntersectionObserver' in window)) {
    $$('.rv,.rv-s').forEach(el => el.classList.add('in'));
    $$('.vs,.orbit,.stars').forEach(el => el.classList.add('in'));
    $$('[data-count]').forEach(el => el.textContent = el.dataset.count + (el.dataset.suffix || ''));
  } else {
    const io = new IntersectionObserver(es => {
      es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: .12, rootMargin: '0px 0px -6% 0px' });
    $$('.rv,.rv-s').forEach(el => io.observe(el));
    const io2 = new IntersectionObserver(es => es.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); }), { threshold: .16 });
    $$('.vs,.orbit,.stars').forEach(el => io2.observe(el));
  }

  /* ---------- count up ---------- */
  {
    const io = new IntersectionObserver(es => {
      es.forEach(e => {
        if (!e.isIntersecting) return;
        const el = e.target, to = +el.dataset.count, sf = el.dataset.suffix || '';
        io.unobserve(el);
        if (RM) { el.textContent = to + sf; return; }
        const d = 1700, t0 = performance.now();
        const s = (t) => {
          const p = Math.min((t - t0) / d, 1);
          el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3))) + sf;
          if (p < 1) raf(s);
        };
        raf(s);
      });
    }, { threshold: .5 });
    $$('[data-count]').forEach(el => io.observe(el));
  }

  /* ---------- the signature move: words brighten as the block scrolls past ---------- */
  {
    const blocks = $$('[data-words]').map(el => {
      const txt = el.textContent;
      el.textContent = '';
      const ws = txt.split(/(\s+)/).map(chunk => {
        const w = document.createElement('w');
        w.textContent = chunk;
        el.appendChild(w);
        return w;
      });
      return { el, ws };
    });
    if (RM) {
      blocks.forEach(b => b.ws.forEach(w => w.classList.add('lit')));
    } else if (blocks.length) {
      let tick = false;
      const run = () => {
        for (const b of blocks) {
          const r = b.el.getBoundingClientRect();
          // 0 when the block's top hits 82% of the viewport, 1 once it passes 34%
          const p = clamp((innerHeight * .82 - r.top) / (r.height + innerHeight * .46), 0, 1);
          const n = Math.round(p * b.ws.length);
          b.ws.forEach((w, i) => w.classList.toggle('lit', i < n));
        }
        tick = false;
      };
      addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
      addEventListener('resize', run);
      run();
    }
  }

  /* ---------- hero: pointer parallax on the phones ---------- */
  if (!RM && HOVER && $('#hero')) {
    const hero = $('#hero');
    hero.addEventListener('pointermove', e => {
      const r = hero.getBoundingClientRect();
      hero.style.setProperty('--px', ((e.clientX - r.left) / r.width - .5).toFixed(3));
      hero.style.setProperty('--py', ((e.clientY - r.top) / r.height - .5).toFixed(3));
    });
    hero.addEventListener('pointerleave', () => {
      hero.style.setProperty('--px', 0); hero.style.setProperty('--py', 0);
    });
  }

  /* ---------- magnetic buttons ---------- */
  if (!RM && HOVER) {
    $$('[data-mag]').forEach(el => {
      el.addEventListener('pointermove', e => {
        const r = el.getBoundingClientRect();
        el.style.setProperty('--mx', ((e.clientX - r.left - r.width / 2) * .2) + 'px');
        el.style.setProperty('--my', ((e.clientY - r.top - r.height / 2) * .28) + 'px');
      });
      el.addEventListener('pointerleave', () => {
        el.style.setProperty('--mx', '0px'); el.style.setProperty('--my', '0px');
      });
    });
  }

  /* ---------- S2: hovering a row lifts its counterpart ---------- */
  {
    const cells = $$('#vs .vs__c');
    const set = (p, on) => cells.forEach(c => { if (c.dataset.p === p) c.classList.toggle('pair', on); });
    cells.forEach(c => {
      c.addEventListener('pointerenter', () => set(c.dataset.p, true));
      c.addEventListener('pointerleave', () => set(c.dataset.p, false));
    });
  }

  /* ---------- S3: the network lights up one connection at a time ---------- */
  {
    const orb = $('#orbit');
    if (orb) {
      const nds = $$('.nd[data-l]', orb);
      let k = 0, t = null;
      const light = (n) => {
        nds.forEach(x => x.classList.remove('hot'));
        $$('.orbit__l', orb).forEach(l => l.classList.remove('hot'));
        const nd = nds[n]; if (!nd) return;
        nd.classList.add('hot');
        $('#l' + nd.dataset.l, orb)?.classList.add('hot');
      };
      const cyc = () => { light(k); k = (k + 1) % nds.length; };
      const go = () => { clearInterval(t); if (!RM) { cyc(); t = setInterval(cyc, 1900); } };
      const stop = () => clearInterval(t);
      nds.forEach((nd, i) => {
        nd.addEventListener('pointerenter', () => { stop(); light(i); });
        nd.addEventListener('pointerleave', () => { k = i; go(); });
      });
      new IntersectionObserver(e => e[0].isIntersecting ? go() : stop(), { threshold: .2 }).observe(orb);
    }
  }

  /* ---------- S5: the workflow fills in as you arrive ---------- */
  {
    const flow = $('#flow');
    if (flow) {
      const steps = $$('.fs', flow);
      let k = -1, t = null;
      const light = (n) => steps.forEach((s, i) => {
        s.classList.toggle('on', i === n);
        s.classList.toggle('done', i < n);
      });
      const tick = () => {
        k += 1;
        if (k >= steps.length) { steps.forEach(s => s.classList.add('done')); light(steps.length - 1); clearInterval(t); return; }
        light(k);
      };
      const go = () => {
        if (RM) { steps.forEach(s => s.classList.add('done')); return; }
        if (k >= steps.length - 1) return;
        clearInterval(t); t = setInterval(tick, 900);
      };
      steps.forEach((s, i) => {
        s.addEventListener('pointerenter', () => { clearInterval(t); light(i); });
        s.addEventListener('pointerleave', () => { k = i; go(); });
      });
      new IntersectionObserver(e => e[0].isIntersecting ? go() : clearInterval(t), { threshold: .3 }).observe(flow);
    }
  }

  /* ---------- S6: the accordion drives the phone ---------- */
  {
    const feat = $('#feat');
    if (feat) {
      const items = $$('.acc__i', feat);
      const btns  = $$('.acc__b', feat);
      const imgs  = $$('#featScreens img');
      const DUR = 5400;
      let n = 0, t = null;
      const pick = (k) => {
        n = (k + items.length) % items.length;
        items.forEach((it, i) => {
          const on = i === n;
          it.classList.toggle('on', on);
          $('.acc__b', it).setAttribute('aria-selected', String(on));
          const bar = $('.acc__bar', it);
          bar.style.animation = 'none'; void bar.offsetWidth; bar.style.animation = '';
        });
        imgs.forEach((im, i) => im.classList.toggle('live', i === n));
      };
      const go = () => { clearInterval(t); if (!RM) t = setInterval(() => pick(n + 1), DUR); };
      const stop = () => clearInterval(t);
      btns.forEach((b, i) => {
        b.addEventListener('click', () => { pick(i); go(); });
        b.addEventListener('keydown', e => {
          if (e.key === 'ArrowDown') { e.preventDefault(); pick(n + 1); btns[n].focus(); go(); }
          if (e.key === 'ArrowUp')   { e.preventDefault(); pick(n - 1); btns[n].focus(); go(); }
        });
      });
      feat.addEventListener('pointerenter', stop);
      feat.addEventListener('pointerleave', go);
      pick(0);
      new IntersectionObserver(e => e[0].isIntersecting ? go() : stop(), { threshold: .22 }).observe(feat);
    }
  }

  /* ---------- S10: tabs ---------- */
  {
    const tabs = $$('.tabs button'), g = $('#glide');
    // the Builders / Brokers split was removed — this block is a no-op without it
    if (tabs.length && g) {
    const slide = (b) => { g.style.width = b.offsetWidth + 'px'; g.style.transform = `translateX(${b.offsetLeft - 5}px)`; };
    const act = (b) => {
      tabs.forEach(o => {
        const on = o === b;
        o.setAttribute('aria-selected', String(on));
        const p = $('#' + o.getAttribute('aria-controls'));
        p.hidden = !on;
        on ? raf(() => p.classList.add('shown')) : p.classList.remove('shown');
      });
      slide(b);
    };
    tabs.forEach((t, i) => {
      t.addEventListener('click', () => act(t));
      t.addEventListener('keydown', e => {
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
          e.preventDefault();
          const nx = tabs[(i + (e.key === 'ArrowRight' ? 1 : tabs.length - 1)) % tabs.length];
          nx.focus(); act(nx);
        }
      });
    });
    const init = () => { slide(tabs[0]); $('#tb-a').classList.add('shown'); };
    document.fonts?.ready ? document.fonts.ready.then(init) : init();
    setTimeout(init, 900);
    addEventListener('resize', () => { const on = tabs.find(t => t.getAttribute('aria-selected') === 'true'); if (on) slide(on); });
    }
  }

  /* ---------- video lightbox ---------- */
  {
    const lb = $('#lb'), m = $('#lbM'), nm = $('#lbN'), rl = $('#lbR');
    let last = null;
    const close = () => { lb.hidden = true; m.innerHTML = ''; document.body.style.overflow = ''; last?.focus(); };
    const open = (c) => {
      last = c;
      const src = c.dataset.video;
      nm.textContent = c.dataset.name; rl.textContent = c.dataset.role;
      m.innerHTML = src
        ? (/\.(mp4|webm|ogg|mov)(\?|$)/i.test(src)
            ? `<video controls autoplay playsinline src="${src}"></video>`
            : `<iframe src="${src}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture" allowfullscreen title="${c.dataset.name}"></iframe>`)
        : `<div class="lb__e"><span class="vc__play" aria-hidden="true"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 4.5v15l13-7.5-13-7.5Z"/></svg></span><strong>Video slot ready</strong><span>Add this testimonial's video URL to the card's <code>data-video</code> attribute and it will play right here.</span></div>`;
      lb.hidden = false; document.body.style.overflow = 'hidden'; $('#lbC').focus();
    };
    $$('.vc').forEach(c => c.addEventListener('click', () => open(c)));
    $('#lbC').addEventListener('click', close);
    lb.addEventListener('click', e => { if (e.target === lb) close(); });
    addEventListener('keydown', e => { if (e.key === 'Escape' && !lb.hidden) close(); });
    lb.addEventListener('keydown', e => {
      if (e.key !== 'Tab') return;
      const f = $$('button,[href],video,iframe', lb).filter(el => el.offsetParent !== null);
      if (!f.length) return;
      const a = f[0], z = f[f.length - 1];
      if (e.shiftKey && document.activeElement === a) { e.preventDefault(); z.focus(); }
      else if (!e.shiftKey && document.activeElement === z) { e.preventDefault(); a.focus(); }
    });
  }

  /* ---------- FAQ ---------- */
  $$('#faqList .qa').forEach(qa => {
    const b = $('.qa__q', qa);
    b.addEventListener('click', () => {
      const open = qa.classList.contains('on');
      $$('#faqList .qa').forEach(o => { o.classList.remove('on'); $('.qa__q', o).setAttribute('aria-expanded', 'false'); });
      if (!open) { qa.classList.add('on'); b.setAttribute('aria-expanded', 'true'); }
    });
  });

  $('#yr').textContent = new Date().getFullYear();
})();

/* ════════════════════════════════════════════════════════════
   v6 — interaction layer
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const FINE = matchMedia("(hover:hover) and (pointer:fine)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;
  const clamp = (v, a, b) => Math.min(Math.max(v, a), b);

  /* ---------- custom cursor ---------- */
  if (FINE && !RM) {
    const ring = document.createElement('div'); ring.className = 'cur';
    const dot  = document.createElement('div'); dot.className  = 'cur-d';
    document.body.append(ring, dot);
    let tx = innerWidth / 2, ty = innerHeight / 2, rx = tx, ry = ty;
    addEventListener('pointermove', e => {
      tx = e.clientX; ty = e.clientY;
      dot.style.transform = `translate(${tx}px,${ty}px)`;
      document.body.classList.add('cur-on');
    }, { passive: true });
    addEventListener('pointerleave', () => document.body.classList.remove('cur-on'));
    const spring = () => {
      rx += (tx - rx) * .16; ry += (ty - ry) * .16;
      ring.style.transform = `translate(${rx}px,${ry}px)`;
      raf(spring);
    };
    raf(spring);

    const HOT = 'a,button,[data-tilt],[data-tilt2],.wnode,.vc,.qt,.scard,.pl,.qa__q';
    document.addEventListener('pointerover', e => {
      const t = e.target.closest?.(HOT);
      ring.classList.toggle('hot', !!t);
      dot.classList.toggle('hide', !!t);
      if (t) {
        // light ring over dark / brand surfaces
        const dark = t.closest('.panel--dark,.panel--brand,.hero,.ftr,.price9,.ctaband');
        ring.classList.toggle('hot-light', !!dark);
      }
    });
  }

  /* ---------- 3D tilt (cards) ---------- */
  if (FINE && !RM) {
    $$('[data-tilt],[data-tilt2]').forEach(el => {
      const deep = el.hasAttribute('data-tilt2');
      el.addEventListener('pointerenter', () => el.classList.add('live'));
      el.addEventListener('pointermove', e => {
        const r = el.getBoundingClientRect();
        const px = (e.clientX - r.left) / r.width - .5;
        const py = (e.clientY - r.top) / r.height - .5;
        el.style.setProperty('--ry', (px * 8).toFixed(2) + 'deg');
        el.style.setProperty('--rx', (-py * 8).toFixed(2) + 'deg');
        if (deep) {
          el.style.setProperty('--mx2', (e.clientX - r.left) + 'px');
          el.style.setProperty('--my2', (e.clientY - r.top) + 'px');
        }
      });
      el.addEventListener('pointerleave', () => {
        el.classList.remove('live');
        el.style.setProperty('--rx', '0deg'); el.style.setProperty('--ry', '0deg');
      });
    });
  }

  /* ---------- extra reveals (left / right / wipe / stagger) ---------- */
  {
    const sel = '.rvl,.rvr,.wipe,.stg';
    if (RM || !('IntersectionObserver' in window)) {
      $$(sel).forEach(el => el.classList.add('in'));
      $$('.plans9').forEach(el => el.classList.add('in'));
    } else {
      const io = new IntersectionObserver(es => {
        es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
      }, { threshold: .12, rootMargin: '0px 0px -6% 0px' });
      $$(sel).forEach(el => io.observe(el));
      const io2 = new IntersectionObserver(es => {
        es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io2.unobserve(e.target); } });
      }, { threshold: .2 });
      $$('.plans9').forEach(el => io2.observe(el));
    }
  }

  /* ---------- a tiny scroll-driver used by both pinned stages ---------- */
  const drive = (wrap, onProgress) => {
    if (!wrap) return;
    let tick = false;
    const run = () => {
      const r = wrap.getBoundingClientRect();
      const span = wrap.offsetHeight - innerHeight;
      onProgress(span > 0 ? clamp(-r.top / span, 0, 1) : 0);
      tick = false;
    };
    addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
    addEventListener('resize', run);
    run();
  };

  /* ---------- S5 · the workflow, one step at a time ---------- */
  {
    const wrap = $('#pin5');
    if (wrap) {
      const nums  = $$('.p5__num span', wrap);
      const steps = $$('.p5__s', wrap);
      const ring  = $('#p5ring');
      const bar   = $('#p5bar');
      const LEN   = 295.3;
      let cur = -1;
      drive(wrap, p => {
        const i = Math.min(steps.length - 1, Math.floor(p * steps.length * 0.999));
        if (ring) ring.style.strokeDashoffset = LEN * (1 - p);
        if (bar)  bar.style.width = (p * 100) + '%';
        if (i === cur) return;
        cur = i;
        nums.forEach((n, k) => n.classList.toggle('on', k === i));
        steps.forEach((s, k) => s.classList.toggle('on', k === i));
      });
    }
  }

  /* ---------- S6 · one tool at a time, phone follows ---------- */
  {
    const wrap = $('#pin6');
    if (wrap) {
      const steps = $$('.p6__s', wrap);
      const imgs  = $$('#p6screens img');
      const dots  = $$('#p6rail b');
      const bar   = $('#p6bar');
      let cur = -1;
      drive(wrap, p => {
        const i = Math.min(steps.length - 1, Math.floor(p * steps.length * 0.999));
        if (bar) bar.style.width = (p * 100) + '%';
        if (i === cur) return;
        cur = i;
        steps.forEach((s, k) => s.classList.toggle('on', k === i));
        imgs.forEach((im, k) => im.classList.toggle('live', k === i));
        dots.forEach((d, k) => d.classList.toggle('on', k === i));
      });
      // phone drifts with the pointer
      if (FINE && !RM) {
        const stage = $('.pin__stage', wrap);
        stage.addEventListener('pointermove', e => {
          const r = stage.getBoundingClientRect();
          stage.style.setProperty('--px', ((e.clientX - r.left) / r.width - .5).toFixed(3));
          stage.style.setProperty('--py', ((e.clientY - r.top) / r.height - .5).toFixed(3));
        });
        stage.addEventListener('pointerleave', () => {
          stage.style.setProperty('--px', 0); stage.style.setProperty('--py', 0);
        });
      }
    }
  }

  /* ---------- S3 · one connection at a time flows into the hub ---------- */
  {
    const nw = $('#nw');
    if (nw) {
      const nodes = $$('.nw__n', nw);
      const hub   = $('#nwHub');
      let k = 0, t = null;

      // each flow path needs its own length so the draw animation lands exactly
      $$('.nw__flow', nw).forEach(p => {
        try { p.style.setProperty('--len', p.getTotalLength().toFixed(1)); } catch (e) {}
      });

      const clear = () => {
        nodes.forEach(n => n.classList.remove('on'));
        $$('.nw__flow, .nw__dot', nw).forEach(el => el.classList.remove('on'));
      };
      const light = (n) => {
        clear();
        nw.classList.add('live');
        nodes[n]?.classList.add('on');
        const fl = $('#fl' + n, nw), dot = $('#dot' + n, nw);
        // restart the animations even when re-selecting the same node
        [fl, dot].forEach(el => { if (el) { el.classList.remove('on'); void el.getBoundingClientRect(); el.classList.add('on'); } });
        // the hub answers as the parcel lands
        clearTimeout(light._p);
        light._p = setTimeout(() => {
          hub.classList.add('ping');
          setTimeout(() => hub.classList.remove('ping'), 420);
        }, 820);
      };
      const cyc = () => { light(k); k = (k + 1) % nodes.length; };
      const go   = () => { clearInterval(t); if (!RM) { cyc(); t = setInterval(cyc, 2300); } };
      const stop = () => { clearInterval(t); clearTimeout(light._p); };

      nodes.forEach((nd, i) => {
        nd.addEventListener('pointerenter', () => { stop(); light(i); });
        nd.addEventListener('focus',        () => { stop(); light(i); });
        nd.addEventListener('click',        () => { stop(); light(i); k = (i + 1) % nodes.length; });
        nd.addEventListener('pointerleave', () => { k = (i + 1) % nodes.length; go(); });
      });

      if (RM) { nw.classList.remove('live'); $$('.nw__flow', nw).forEach(f => f.classList.add('on')); }
      else new IntersectionObserver(e => e[0].isIntersecting ? go() : stop(), { threshold: .2 }).observe(nw);
    }
  }

  /* ---------- safety net: never leave a revealed-on-scroll element hidden ----------
     IntersectionObserver can be outrun by fast programmatic scrolling or a restored
     scroll position. Anything already above the fold gets revealed regardless. */
  {
    let pending = $$('.rv,.rv-s,.rvl,.rvr,.wipe,.stg');
    if (pending.length) {
      let tick = false;
      const sweep = () => {
        if (pending.length) {
          pending = pending.filter(el => {
            if (el.classList.contains('in')) return false;
            if (el.getBoundingClientRect().top < innerHeight * 0.94) { el.classList.add('in'); return false; }
            return true;
          });
        }
        tick = false;
      };
      addEventListener('scroll', () => { if (!tick) { tick = true; raf(sweep); } }, { passive: true });
      addEventListener('resize', sweep);
      setTimeout(sweep, 400);
    }
  }

  /* ---------- gentle scroll parallax on marked elements ---------- */
  if (!RM) {
    const items = $$('[data-par]').map(el => ({ el, k: parseFloat(el.dataset.par) || .08 }));
    if (items.length) {
      let tick = false;
      const run = () => {
        for (const it of items) {
          const r = it.el.getBoundingClientRect();
          const mid = r.top + r.height / 2 - innerHeight / 2;
          it.el.style.setProperty('--par', (-mid * it.k).toFixed(1) + 'px');
        }
        tick = false;
      };
      addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
      run();
    }
  }
})();

/* ════════════════════════════════════════════════════════════
   v7 — frame opening, heading word-rise, sheens, S5 screens
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;
  const clamp = (v, a, b) => Math.min(Math.max(v, a), b);

  /* ---------- the frame opens out to the edges on first scroll ----------
     --frame / --r-frame drive the page inset AND the fixed header, so
     easing them to 0 makes the whole design go full-bleed as you go. */
  {
    const root = document.documentElement;
    const cs = getComputedStyle(root);
    const F0 = parseFloat(cs.getPropertyValue('--frame')) || 12;
    const R0 = parseFloat(cs.getPropertyValue('--r-frame')) || 30;
    let tick = false;
    const run = () => {
      // fully open by the time you've scrolled half a viewport
      const p = clamp(scrollY / (innerHeight * 0.45), 0, 1);
      const e = 1 - Math.pow(1 - p, 3);          // ease-out
      root.style.setProperty('--frame', (F0 * (1 - e)).toFixed(2) + 'px');
      root.style.setProperty('--r-frame', (R0 * (1 - e)).toFixed(2) + 'px');
      root.classList.toggle('bleed', p > .98);
      tick = false;
    };
    addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
    addEventListener('resize', run);
    run();
  }

  /* ---------- headings rise word by word ---------- */
  {
    const wrapWords = (el) => {
      const walk = (node) => {
        [...node.childNodes].forEach(n => {
          if (n.nodeType === 3) {
            const t = n.textContent;
            if (!t.trim()) return;
            const frag = document.createDocumentFragment();
            t.split(/(\s+)/).forEach(tok => {
              if (!tok) return;
              if (/^\s+$/.test(tok)) { frag.appendChild(document.createTextNode(tok)); return; }
              const w = document.createElement('span'); w.className = 'wd';
              const i = document.createElement('i'); i.textContent = tok;
              w.appendChild(i); frag.appendChild(w);
            });
            n.replaceWith(frag);
          } else if (n.nodeType === 1 && !n.classList.contains('wd')) {
            walk(n);
          }
        });
      };
      walk(el);
      $$('.wd > i', el).forEach((i, k) => i.style.setProperty('--wd', (k * 48) + 'ms'));
    };

    // every section heading except the hero (already line-masked) and the
    // over-scale statement (driven by the scroll word-reveal)
    const heads = $$('h2.d2, h3.d3, .ctaband h2').filter(h => !h.querySelector('[data-words]'));
    heads.forEach(h => {
      h.classList.remove('rv');      // the word-rise replaces the block fade
      h.classList.add('sp');
      wrapWords(h);
    });

    if (RM || !('IntersectionObserver' in window)) {
      heads.forEach(h => h.classList.add('in'));
    } else {
      const io = new IntersectionObserver(es => {
        es.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
      }, { threshold: .2, rootMargin: '0px 0px -16% 0px' });
      heads.forEach(h => io.observe(h));
      // safety net — reveal anything already above the fold
      let pend = heads.slice();
      let t2 = false;
      const sweep = () => {
        pend = pend.filter(h => {
          if (h.classList.contains('in')) return false;
          if (h.getBoundingClientRect().top < innerHeight * .86) { h.classList.add('in'); return false; }
          return true;
        });
        t2 = false;
      };
      addEventListener('scroll', () => { if (!t2) { t2 = true; raf(sweep); } }, { passive: true });
      setTimeout(sweep, 500);
    }
  }

  /* ---------- sheen sweep on every card surface ---------- */
  {
    const light = '.scard, .why__c, .store';
    const dark  = '.pain, .pl, .vc, .qt, .ctaband';
    $$(light).forEach(el => { el.classList.add('fx'); el.appendChild(Object.assign(document.createElement('i'), { className: 'sheen' })); });
    $$(dark).forEach(el => { el.classList.add('fx', 'fx--d'); el.appendChild(Object.assign(document.createElement('i'), { className: 'sheen' })); });
  }

  /* ---------- S5 · swap the screen with each step ---------- */
  {
    const wrap = $('#pin5');
    if (wrap) {
      const imgs  = $$('#p5imgs img');
      const ghost = $('.p5__ghost', wrap);
      const steps = $$('.p5__s', wrap);
      let cur = -1;
      const sync = () => {
        const i = steps.findIndex(s => s.classList.contains('on'));
        if (i < 0 || i === cur) return;
        cur = i;
        imgs.forEach((im, k) => im.classList.toggle('live', k === i));
        if (ghost) ghost.textContent = String(i + 1).padStart(2, '0');
      };
      // the pinned driver owns .on — mirror it here
      new MutationObserver(sync).observe($('.p5__txt', wrap), { attributes: true, subtree: true, attributeFilter: ['class'] });
      sync();

      // the shot drifts with the pointer
      if (!RM && matchMedia('(hover:hover) and (pointer:fine)').matches) {
        const stage = $('.pin__stage', wrap);
        stage.addEventListener('pointermove', e => {
          const r = stage.getBoundingClientRect();
          stage.style.setProperty('--px', ((e.clientX - r.left) / r.width - .5).toFixed(3));
          stage.style.setProperty('--py', ((e.clientY - r.top) / r.height - .5).toFixed(3));
        });
        stage.addEventListener('pointerleave', () => {
          stage.style.setProperty('--px', 0); stage.style.setProperty('--py', 0);
        });
      }
    }
  }
})();

/* ════════════════════════════════════════════════════════════
   v8 — scroll-triggered reveals across every section
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;

  /* ------------------------------------------------------------------
     1 · tag everything that should arrive on scroll.
        [selector, variant, stagger-ms, base-delay-ms]
        Elements that already carry a v5 .rv/.rv-s are skipped so we
        never animate the same thing twice.
     ------------------------------------------------------------------ */
  const PLAN = [
    // S1 hero
    ['.trust__i',                 'up',    90,   0],
    // S2 network gap
    // S3 connect
    ['#web',                      'scale', 0,    80],
    // S4 property + requirements
    ['.scatter .scard',           'rise',  120,  0],
    // S5 workflow intro
    ['#how .body-lg',             'up',    0,    80],
    // S6 features intro
    ['#features .body-lg',        'up',    0,    80],
    // S7 statement
    ['#more .stmt__cta, #more .body-lg', 'up', 0, 120],
    // S8 why
    ['.why8__grid .gcard',        'rise',  110,  0],
    // S9 pricing
    ['.seal9',                    'scale', 0,    0],
    ['.plans9 .pl',               'rise',  100,  60],
    ['.ctaband .stores .store',   'up',    90,   140],
    // S10 testimonials
    ['.tabs',                     'up',    0,    60],
    ['.note',                     'up',    0,    120],
    ['.tg .vc, .tg .qt',          'rise',  110,  0],
    // S11 FAQ
    ['.faq .qa',                  'up',    55,   0],
    // footer
    ['.ftr__t > *',               'up',    100,  0],

    /* ---- v24: the sections the first pass never reached ----
       Audited in the browser: #network was at 0% coverage, #features 5%,
       #how 7%, #connect 14%. Anything inside a pinned stage is left alone,
       since those slides are driven by their own scroll timeline. */
    ['.vsxcard',                      'rise',  0,    40],
    ['#connect .c3__head',            'up',    0,    0],
    ['#connect .c3__cta > *',         'up',    90,   110],
    ['#connect .nw',                  'scale', 0,    140],
    ['#inventory .h-sm',              'up',    0,    60],
    ['#inventory .btn',               'up',    0,    140],
    ['#how .kicker, #features .kicker',       'up', 0, 0],
    ['#why .kicker, #pricing .kicker',        'up', 0, 0],
    ['#why .body-lg, #pricing > .wrap .body-lg', 'up', 0, 90],
    ['.ctaband h2',                   'up',    0,    0],
    ['.ctaband .body-lg',             'up',    0,    90],
    ['.faq2__contact',                'rise',  0,    140],
    ['#testimonials .tcta__w',        'scale', 0,    160]
  ];

  const tagged = [];
  PLAN.forEach(([sel, variant, step, base]) => {
    $$(sel).forEach((el, i) => {
      if (el.hasAttribute('data-rev')) return;
      if (el.classList.contains('rv') || el.classList.contains('rv-s')) return;
      el.setAttribute('data-rev', variant);
      el.style.setProperty('--d', (base + i * step) + 'ms');
      tagged.push(el);
    });
  });

  /* stagger the children of any grid that arrives as a block */
  $$('.stg').forEach(g => $$(':scope > *', g).forEach((c, i) => c.style.setProperty('--i', i)));

  /* ------------------------------------------------------------------
     2 · reveal them
     ------------------------------------------------------------------ */
  const show = el => el.classList.add('shown');
  if (RM || !('IntersectionObserver' in window)) {
    tagged.forEach(show);
  } else {
    const io = new IntersectionObserver(es => {
      es.forEach(e => { if (e.isIntersecting) { show(e.target); io.unobserve(e.target); } });
    }, { threshold: .12, rootMargin: '0px 0px -18% 0px' });
    tagged.forEach(el => io.observe(el));

    // safety net — anything already past the fold is shown regardless
    let pend = tagged.slice(), tick = false;
    const sweep = () => {
      pend = pend.filter(el => {
        if (el.classList.contains('shown')) return false;
        if (el.getBoundingClientRect().top < innerHeight * .85) { show(el); return false; }
        return true;
      });
      tick = false;
    };
    addEventListener('scroll', () => { if (!tick) { tick = true; raf(sweep); } }, { passive: true });
    addEventListener('resize', sweep);
    setTimeout(sweep, 500);
  }

  /* ------------------------------------------------------------------
     3 · quiet parallax — a second layer of life, not the main event
     ------------------------------------------------------------------ */
  if (!RM) {
    const SPEEDS = [
      ['.scatter .scard',  [.042, .080, .034]],
      ['.why8__grid .gcard',[.034, .068, .046]],
      ['.plans9 .pl',      [.026, .054, .038, .066]],
      ['.tg .vc, .tg .qt', [.038, .068, .048]],
      ['.vsxcard',         [.022]],
      ['#web',             [.042]],
      ['.faq',             [.024]],
      ['.ftr__b1',         [.034]],
      ['.ph--banner',      [.055]]
    ];
    /* Giving each card in a grid its own speed reads as life when they sit
       side by side. Stacked in one column it closes the gap between them and
       they visibly overlap — #inventory measured -22px between cards 2 and 3
       on a phone. Below 1040 only the whole-block items keep drifting. */
    const SOLO = new Set(['.vsxcard', '#web', '.faq', '.ftr__b1', '.ph--banner']);
    const narrow = matchMedia('(max-width:1040px)');
    let items = [];
    const build = () => {
      items.forEach(o => o.el.style.removeProperty('--pyy'));
      items = [];
      SPEEDS.forEach(([sel, ks]) => {
        if (narrow.matches && !SOLO.has(sel)) return;
        $$(sel).forEach((el, i) => items.push({ el, k: ks[i % ks.length] }));
      });
    };
    build();
    narrow.addEventListener('change', () => { build(); run(); });

    let tick = false;
    const run = () => {
      const vh = innerHeight;
      for (const o of items) {
        const r = o.el.getBoundingClientRect();
        if (r.bottom < -200 || r.top > vh + 200) continue;   // skip off-screen
        const mid = r.top + r.height / 2 - vh / 2;
        o.el.style.setProperty('--pyy', (-mid * o.k).toFixed(1) + 'px');
      }
      tick = false;
    };
    addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
    addEventListener('resize', run);
    run();
  }
})();

/* ════════════════════════════════════════════════════════════
   v9 — drag-to-compare + S8 photo parallax
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;
  const clamp = (v, a, b) => Math.min(Math.max(v, a), b);

  /* ---------- S2 · the blockers deal in, one per scroll step ---------- */
  {
    const wrap = document.getElementById('pin2');
    if (wrap) {
      const cards = $$('.g2c', wrap);
      const dots  = $$('#g2dots b');
      const bar   = document.getElementById('p2bar');
      let cur = -1, tick = false;

      const paint = () => {
        const r = wrap.getBoundingClientRect();
        const span = wrap.offsetHeight - innerHeight;
        const p = span > 0 ? clamp(-r.top / span, 0, 1) : 0;
        if (bar) bar.style.width = (p * 100) + '%';
        // 0 → first card, 1 → all three
        const n = Math.min(cards.length - 1, Math.floor(p * cards.length * 0.999));
        if (n !== cur) {
          cur = n;
          cards.forEach((c, i) => c.classList.toggle('on', i <= n));
          dots.forEach((d, i) => d.classList.toggle('on', i === n));
        }
        tick = false;
      };
      /* Below 1040 the stage is unpinned (it cannot fit one column of
         content in 100svh), so there is no scroll distance to deal the
         cards across — each one arrives as it comes into view instead. */
      const MQ = matchMedia('(max-width:1040px)');
      let io = null;
      const flow = () => {
        if (io || !('IntersectionObserver' in window)) {
          if (!io) cards.forEach(c => c.classList.add('on'));
          return;
        }
        io = new IntersectionObserver(es => es.forEach(e => {
          if (e.isIntersecting) { e.target.classList.add('on'); io.unobserve(e.target); }
        }), { threshold: .2, rootMargin: '0px 0px -8% 0px' });
        cards.forEach(c => io.observe(c));
      };

      if (RM) {
        cards.forEach(c => c.classList.add('on'));
        dots.forEach(d => d.classList.add('on'));
      } else {
        addEventListener('scroll', () => {
          if (MQ.matches || tick) return;      /* unpinned — nothing to drive */
          tick = true; raf(paint);
        }, { passive: true });
        addEventListener('resize', () => { if (!MQ.matches) paint(); });
        /* if the viewport crosses the breakpoint, hand over to the other mode */
        MQ.addEventListener('change', e => { if (e.matches) flow(); else { cur = -1; paint(); } });
        if (MQ.matches) flow(); else paint();
      }
    }
  }

  /* ---------- S2 · the two panels animate in together ---------- */
  {
    const vsx = document.getElementById('vsx');
    if (vsx) {
      if (RM || !('IntersectionObserver' in window)) vsx.classList.add('in');
      else {
        const io = new IntersectionObserver((es, o) => {
          if (es[0].isIntersecting) { vsx.classList.add('in'); o.disconnect(); }
        }, { threshold: .2 });
        io.observe(vsx);
        setTimeout(() => { if (vsx.getBoundingClientRect().top < innerHeight * .95) vsx.classList.add('in'); }, 700);
      }
    }
  }

  /* ---------- S8 · the photograph drifts behind the cards ---------- */
  if (!RM) {
    const img = $('#why8img'), sec = $('#why');
    if (img && sec) {
      let tick = false;
      const run = () => {
        const r = sec.getBoundingClientRect();
        if (r.bottom > -200 && r.top < innerHeight + 200) {
          const mid = r.top + r.height / 2 - innerHeight / 2;
          img.style.setProperty('--pyy', (-mid * 0.07).toFixed(1) + 'px');
        }
        tick = false;
      };
      addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
      addEventListener('resize', run);
      run();
    }
  }
})();

/* ════════════════════════════════════════════════════════════
   v11 — step thread wiring + S3 photo drift
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;

  /* ---------- S5 · thread follows the pinned step, and can drive it ---------- */
  {
    const wrap = $('#pin5'), thr = $('#p5thr');
    if (wrap && thr) {
      const nodes = $$('.thr__n', thr);
      const line  = $('#p5line');
      const cur   = $('#p5cur');
      const steps = $$('.p5__s', wrap);
      const N = nodes.length;

      // the rail should stop at the centre of the last node, not run past it
      const fitRail = () => {
        const last = nodes[N - 1], first = nodes[0];
        const tail = thr.offsetWidth - (last.offsetLeft + last.offsetWidth / 2);
        thr.style.setProperty('--tail', tail + 'px');
        void first;
      };
      fitRail();
      addEventListener('resize', fitRail);
      document.fonts?.ready?.then(fitRail);

      const paint = () => {
        const i = steps.findIndex(s => s.classList.contains('on'));
        if (i < 0) return;
        nodes.forEach((n, k) => {
          n.classList.toggle('on', k === i);
          n.classList.toggle('done', k < i);
          n.setAttribute('aria-selected', String(k === i));
        });
        if (line) line.style.width = (N > 1 ? (i / (N - 1)) * 100 : 0) + '%';
        if (cur) cur.textContent = String(i + 1).padStart(2, '0');
      };
      new MutationObserver(paint).observe($('.p5__txt', wrap), { attributes: true, subtree: true, attributeFilter: ['class'] });
      paint();

      // clicking a number scrolls to that step inside the pinned range
      nodes.forEach((n, i) => {
        n.addEventListener('click', () => {
          const span = wrap.offsetHeight - innerHeight;
          const top = wrap.getBoundingClientRect().top + scrollY + span * ((i + .5) / N);
          scrollTo({ top, behavior: RM ? 'auto' : 'smooth' });
        });
        n.addEventListener('keydown', e => {
          if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
            e.preventDefault();
            nodes[(i + (e.key === 'ArrowRight' ? 1 : N - 1)) % N].focus();
          }
        });
      });
    }
  }

  /* ---------- S3 · the photograph drifts behind the network ---------- */
  if (!RM) {
    const img = $('#c3img'), sec = $('#connect');
    if (img && sec) {
      let tick = false;
      const run = () => {
        const r = sec.getBoundingClientRect();
        if (r.bottom > -240 && r.top < innerHeight + 240) {
          const mid = r.top + r.height / 2 - innerHeight / 2;
          img.style.setProperty('--pyy', (-mid * 0.055).toFixed(1) + 'px');
        }
        tick = false;
      };
      addEventListener('scroll', () => { if (!tick) { tick = true; raf(run); } }, { passive: true });
      addEventListener('resize', run);
      run();
    }
  }
})();


/* ════════════════════════════════════════════════════════════
   v21 — app-download chooser + screenshot-accurate phone frames
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => [...r.querySelectorAll(s)];

  /* ---------- the app-download chooser ----------
     Opened by every CTA that does not name a store. The store buttons inside
     the hero, the closing band and the footer still link straight through. */
  {
    const m = $('#appm');
    if (m) {
      const closeBtn = $('#appmC', m);
      let last = null;

      const close = () => {
        if (m.hidden) return;
        m.hidden = true;
        document.body.style.overflow = '';
        if (last) { last.focus(); last = null; }
      };
      const open = (trigger) => {
        last = trigger;
        m.hidden = false;
        document.body.style.overflow = 'hidden';
        closeBtn.focus();
      };

      $$('[data-appm]').forEach(b => b.addEventListener('click', (e) => {
        e.preventDefault();
        open(b);
      }));
      closeBtn.addEventListener('click', close);
      m.addEventListener('click', (e) => { if (e.target === m) close(); });
      addEventListener('keydown', (e) => { if (e.key === 'Escape' && !m.hidden) close(); });

      // keep tabbing inside the dialog while it is open
      m.addEventListener('keydown', (e) => {
        if (e.key !== 'Tab') return;
        const f = $$('button,[href]', m).filter(el => el.offsetParent !== null);
        if (!f.length) return;
        const first = f[0], lastEl = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); lastEl.focus(); }
        else if (!e.shiftKey && document.activeElement === lastEl) { e.preventDefault(); first.focus(); }
      });

      // a visitor who picks a store has finished with the dialog
      $$('.store', m).forEach(a => a.addEventListener('click', () => setTimeout(close, 120)));
    }
  }

  /* ---------- phone frames take the screenshots' own ratio ----------
     Rather than forcing every export into 390x788 and cropping the overflow,
     each frame adopts the natural ratio of the image it holds. Drop in a new
     set of app screens at any size and nothing gets cut. */
  {
    const fit = (frame, img) => {
      if (!img.naturalWidth || !img.naturalHeight) return;
      frame.style.setProperty('--shot', img.naturalWidth + '/' + img.naturalHeight);
      frame.style.setProperty('--shotW', (img.naturalWidth / img.naturalHeight).toFixed(4));
    };
    $$('.p5__frame, .p6__d').forEach(frame => {
      const img = $('img', frame);
      if (!img) return;
      if (img.complete) fit(frame, img);
      else img.addEventListener('load', () => fit(frame, img), { once: true });
    });
  }
})();


/* ════════════════════════════════════════════════════════════
   v24 — pointer spotlight across the card families
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const RM = matchMedia("(prefers-reduced-motion: reduce)").matches;
  const FINE = matchMedia("(hover:hover) and (pointer:fine)").matches;
  if (RM || !FINE) return;

  const $$ = (s, r = document) => [...r.querySelectorAll(s)];
  const raf = requestAnimationFrame;

  // the card surfaces worth lighting up; each gets its own overlay element so
  // we never fight a card that already uses ::before/::after for its own art
  const CARDS = '.scard, .gcard, .pl, .vc, .qt, .vsxcard, .faq2__contact, .g2c, .trust__i';
  const cards = $$(CARDS);
  cards.forEach(c => {
    if (c.querySelector(':scope > .spot')) return;
    c.classList.add('fxs');
    const i = document.createElement('i');
    i.className = 'spot';
    i.setAttribute('aria-hidden', 'true');
    c.appendChild(i);
  });

  let pending = null, ticking = false;
  const apply = () => {
    if (pending) {
      const { el, x, y } = pending;
      el.style.setProperty('--mx', x + '%');
      el.style.setProperty('--my', y + '%');
      pending = null;
    }
    ticking = false;
  };

  addEventListener('pointermove', (e) => {
    const el = e.target.closest ? e.target.closest(CARDS) : null;
    if (!el) return;
    const r = el.getBoundingClientRect();
    if (!r.width || !r.height) return;
    pending = {
      el,
      x: (((e.clientX - r.left) / r.width) * 100).toFixed(1),
      y: (((e.clientY - r.top) / r.height) * 100).toFixed(1)
    };
    if (!ticking) { ticking = true; raf(apply); }
  }, { passive: true });
})();


/* ════════════════════════════════════════════════════════════
   v29 — testimonial carousel arrows
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const $ = (s, r = document) => r.querySelector(s);

  const track = $('#tb-a'), prev = $('#tPrev'), next = $('#tNext');
  if (!track || !prev || !next) return;

  // one click moves by a whole page of cards, so the set never lands half-shown
  const page = () => {
    const first = track.firstElementChild;
    if (!first) return track.clientWidth;
    const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
    const card = first.getBoundingClientRect().width + gap;
    const per = Math.max(1, Math.round(track.clientWidth / card));
    return card * per;
  };

  const sync = () => {
    const max = track.scrollWidth - track.clientWidth;
    prev.disabled = track.scrollLeft <= 2;
    next.disabled = track.scrollLeft >= max - 2;
  };

  prev.addEventListener('click', () => { track.scrollLeft -= page(); });
  next.addEventListener('click', () => { track.scrollLeft += page(); });

  let tick = false;
  track.addEventListener('scroll', () => {
    if (tick) return;
    tick = true;
    requestAnimationFrame(() => { sync(); tick = false; });
  }, { passive: true });

  addEventListener('resize', sync);
  // the cards arrive on a reveal, so measure once they have settled too
  sync();
  setTimeout(sync, 400);
  setTimeout(sync, 1600);
})();



/* ════════════════════════════════════════════════════════════
   v32 — publish the fixed bar's real height
   ════════════════════════════════════════════════════════════ */
(() => {
  "use strict";
  const hdr = document.querySelector('.hdr');
  if (!hdr) return;

  /* The pinned stages are `sticky; top:0`, so the bar paints over the top of
     them and they need to know how much room it takes before they centre
     anything. The bar shrinks once the page frame eases to full bleed, so
     the value only ever grows — a figure that changed mid-scroll would push
     the stage's content around, which is exactly what it is here to stop. */
  let tallest = 0;
  const set = () => {
    const h = Math.round(hdr.getBoundingClientRect().height);
    if (h > tallest) {
      tallest = h;
      document.documentElement.style.setProperty('--hdrH', tallest + 'px');
    }
  };

  set();
  setTimeout(set, 120);
  setTimeout(set, 900);
  addEventListener('resize', () => { tallest = 0; set(); });
})();

