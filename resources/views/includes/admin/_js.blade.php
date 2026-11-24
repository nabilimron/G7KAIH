<script>
const P={
  'layout-dashboard':'<rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/>',
  'users-round':'<path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/><path d="M22 20c0-3.4-2-6.5-4-8a5 5 0 0 0-.5-8.3"/>',
  'user-round-check':'<path d="M2 21a8 8 0 0 1 13.3-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/>',
  'school':'<path d="M14 21v-3a2 2 0 0 0-4 0v3M18 5v16M22 9.5V19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9.5"/><path d="m2 9.5 8.2-6.3a3 3 0 0 1 3.6 0L22 9.5"/><circle cx="12" cy="10" r="2"/>',
  'award':'<circle cx="12" cy="8" r="6"/><path d="M15.5 12.9 17 22l-5-3-5 3 1.5-9.1"/>',
  'chart-column':'<path d="M3 3v16a2 2 0 0 0 2 2h16M18 17V9M13 17V5M8 17v-3"/>',
  'settings':'<path d="M12.2 2h-.4a2 2 0 0 0-2 2v.2a2 2 0 0 1-1 1.7l-.4.2a2 2 0 0 1-2 0l-.2-.1a2 2 0 0 0-2.7.7l-.2.4a2 2 0 0 0 .7 2.7l.2.1a2 2 0 0 1 1 1.7v.5a2 2 0 0 1-1 1.7l-.2.1a2 2 0 0 0-.7 2.7l.2.4a2 2 0 0 0 2.7.7l.2-.1a2 2 0 0 1 2 0l.4.2a2 2 0 0 1 1 1.7V20a2 2 0 0 0 2 2h.4a2 2 0 0 0 2-2v-.2a2 2 0 0 1 1-1.7l.4-.2a2 2 0 0 1 2 0l.2.1a2 2 0 0 0 2.7-.7l.2-.4a2 2 0 0 0-.7-2.7l-.2-.1a2 2 0 0 1-1-1.7v-.5a2 2 0 0 1 1-1.7l.2-.1a2 2 0 0 0 .7-2.7l-.2-.4a2 2 0 0 0-2.7-.7l-.2.1a2 2 0 0 1-2 0l-.4-.2a2 2 0 0 1-1-1.7V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>',
  'bell':'<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9M10.3 21a2 2 0 0 0 3.4 0"/>',
  'calendar-days':'<path d="M8 2v4M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01"/>',
  'file-text':'<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4M10 9H8M16 13H8M16 17H8"/>',
  'file-check':'<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4m-10 7 2 2 4-4"/>',
  'plus':'<path d="M5 12h14M12 5v14"/>',
  'search':'<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
  'chevron-down':'<path d="m6 9 6 6 6-6"/>',
  'chevron-right':'<path d="m9 18 6-6-6-6"/>',
  'pencil':'<path d="M21.2 6.8a1 1 0 0 0-4-4L3.8 16.2a2 2 0 0 0-.5.8L2 21.4a.5.5 0 0 0 .6.6l4.4-1.3a2 2 0 0 0 .8-.5z"/>',
  'trash':'<path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/>',
  'key-round':'<path d="M2.6 17.4A2 2 0 0 0 2 18.8V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.2a2 2 0 0 0 1.4-.6l.8-.8a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5"/>',
  'save':'<path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7M7 3v4a1 1 0 0 0 1 1h7"/>',
  'info':'<circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/>',
  'shield-check':'<path d="M20 13c0 5-3.5 7.5-7.7 9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.2-2.7a1.2 1.2 0 0 1 1.5 0C14.5 3.8 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
  'eye-off':'<path d="M10.7 5.1a10.7 10.7 0 0 1 11.2 6.5 1 1 0 0 1 0 .7 10.7 10.7 0 0 1-1.4 2.5M14.1 14.2a3 3 0 0 1-4.2-4.2M17.5 17.5a10.8 10.8 0 0 1-15.4-5.2 1 1 0 0 1 0-.7 10.8 10.8 0 0 1 4.4-5.1M2 2l20 20"/>',
  'clock':'<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
  'arrow-right':'<path d="M5 12h14M12 5l7 7-7 7"/>',
  'sunrise':'<path d="M12 2v8M4.9 10.9l1.4 1.4M2 18h2M20 18h2M19.1 10.9l-1.4 1.4M22 22H2M8 6l4-4 4 4M16 18a4 4 0 0 0-8 0"/>',
  'heart-handshake':'<path d="M19 14c1.5-1.5 3-3.2 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.8 0-3 .5-4.5 2-1.5-1.5-2.7-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4 3 5.5l7 7z"/><path d="M12 5 9 8a2.2 2.2 0 0 0 0 3.1c.8.8 2.1.8 3 .1l2-1.9a2.8 2.8 0 0 1 3.8 0l3 2.7"/>',
  'book-open':'<path d="M12 7v14M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
  'clipboard-check':'<rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2m1 11 2 2 4-4"/>',
  'clipboard-list':'<rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2M12 11h4M12 16h4M8 11h.01M8 16h.01"/>',
  'bike':'<circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/>',
  'circle-check':'<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
  'circle-x':'<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/>',
  'camera':'<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/>',
  'menu':'<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
  'user-round':'<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>',
  'hourglass':'<path d="M5 22h14M5 2h14M17 22v-4.2a2 2 0 0 0-.6-1.4L12 12l-4.4 4.4A2 2 0 0 0 7 17.8V22M7 2v4.2a2 2 0 0 0 .6 1.4L12 12l4.4-4.4A2 2 0 0 0 17 6.2V2"/>',
  'file-down':'<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z"/><path d="M14 2v4a2 2 0 0 0 2 2h4M12 18v-6m-3 3 3 3 3-3"/>',
  'sun':'<circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/>',
  'moon':'<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>',
  'log-out':'<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>'
};
const ic=n=>`<svg class="i" viewBox="0 0 24 24" aria-hidden="true">${P[n]||''}</svg>`;
const paint=r=>(r||document).querySelectorAll('[data-i]').forEach(e=>{e.outerHTML=ic(e.dataset.i).replace('class="i"','class="i" style="'+(e.getAttribute('style')||'')+'"')});
const $=s=>document.querySelector(s),$$=s=>[...document.querySelectorAll(s)];
function toast(t){const e=$('#toast');if(!e)return;e.textContent=t;e.classList.add('on');clearTimeout(e._t);e._t=setTimeout(()=>e.classList.remove('on'),2400)}
function syncThemeBtn(){const b=document.querySelector('.theme-circle');if(!b)return;const d=document.documentElement.getAttribute('data-theme')==='dark';b.innerHTML=ic(d?'sun':'moon');b.setAttribute('aria-pressed',d?'true':'false')}
function toggleTheme(){const r=document.documentElement,d=r.getAttribute('data-theme')==='dark';if(d){r.removeAttribute('data-theme');try{localStorage.setItem('g7kaih-theme','light')}catch(e){}}else{r.setAttribute('data-theme','dark');try{localStorage.setItem('g7kaih-theme','dark')}catch(e){}}syncThemeBtn()}
let _lastTrigger=null,_openOverlay=null;
function openOverlay(id,trigger){
  const el=document.getElementById(id);if(!el)return;
  _lastTrigger=trigger||document.activeElement;
  _openOverlay=el;
  el.classList.add('is-open');
  el.style.display='flex';
  const focusable=el.querySelector('input,select,textarea,button,a[href]');
  if(focusable)focusable.focus();
}
function closeOverlay(id){
  const el=id?document.getElementById(id):_openOverlay;
  if(!el)return;
  el.classList.remove('is-open');
  el.style.display='none';
  if(_lastTrigger&&typeof _lastTrigger.focus==='function')_lastTrigger.focus();
  _openOverlay=null;
}
document.addEventListener('keydown',function(e){if(e.key==='Escape'&&_openOverlay)closeOverlay()});
document.addEventListener('DOMContentLoaded',function(){syncThemeBtn();paint()});
</script>
