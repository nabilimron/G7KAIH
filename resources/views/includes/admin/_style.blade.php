<style>
:root{
  --ink:#102E54;
  --mut:#5A6D88;
  --line:#CBD7E5;
  --line-soft:#E3EBF3;
  --bg:#EEF3F8;
  --card:#FFFFFF;
  --card-2:#F6F9FC;
  --pri:#1F6FD6;
  --pri-hover:#0969AA;
  --soft:#EAF4FF;
  --ok:#07805D;
  --okbg:#E9F6F1;
  --oktx:#066B4E;
  --wait:#B77913;
  --waitbg:#FFF6E5;
  --waittx:#7C4A03;
  --bad:#C52D49;
  --badbg:#FDECEF;
  --badtx:#B4233C;
  --tier-ok:#17B979;
  --tier-on-ok:#0B1828;
  --tier-wait:#EFBD37;
  --tier-on-wait:#102E54;
  --tier-bad:#C52D49;
  --tier-on-bad:#FFFFFF;
  --chart-bar:#A9CDFB;
  --chart-hi:#247EF2;
}
[data-theme="dark"]{
  color-scheme:dark;
  --ink:#F4F8FC;
  --mut:#98A8BC;
  --line:#2A456A;
  --line-soft:#1F3552;
  --bg:#0B1828;
  --card:#11233A;
  --card-2:#172D49;
  --pri:#7FB3F7;
  --pri-hover:#A9CDFB;
  --soft:#13304F;
  --ok:#5FD3A4;
  --okbg:#0F2F27;
  --oktx:#5FD3A4;
  --wait:#F3CD6A;
  --waitbg:#33270E;
  --waittx:#F3CD6A;
  --bad:#F38A9B;
  --badbg:#3A1520;
  --badtx:#F38A9B;
  --tier-ok:#5FD3A4;
  --tier-on-ok:#0B1828;
  --tier-wait:#F3CD6A;
  --tier-on-wait:#0B1828;
  --tier-bad:#F38A9B;
  --tier-on-bad:#0B1828;
  --chart-bar:#2A456A;
  --chart-hi:#7FB3F7;
}
*,*::before,*::after{box-sizing:border-box;margin:0}
html,body{min-height:100vh;overflow-x:clip;font-family:'Inter',system-ui,-apple-system,sans-serif;background:var(--bg);color:var(--ink);font-size:13px;line-height:1.45;-webkit-font-smoothing:antialiased}
body{display:flex;flex-direction:column}
a{color:inherit;text-decoration:none}
small{font-size:12px}
button,input,select,textarea{font:inherit;color:inherit}
button{border:0;background:none}
a[href],button:not(:disabled),[role="button"]:not([aria-disabled="true"]),select:not(:disabled),summary,label.sw{cursor:pointer}
button:disabled,input:disabled,select:disabled,[aria-disabled="true"]{cursor:not-allowed;opacity:.6}
svg.i{width:1em;height:1em;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
:focus-visible{outline:2px solid var(--pri);outline-offset:2px}

/* Top Bar (Unified with /student) */
.app-header{position:sticky;top:0;z-index:40;background:var(--card);border-bottom:1px solid var(--line-soft);min-height:80px;width:100%;display:flex;align-items:center}
.app-header__inner{width:100%;padding:0 clamp(16px,2.5vw,32px);display:flex;align-items:center;justify-content:space-between;gap:16px}
.brand{display:inline-flex;align-items:center;gap:10px;min-height:44px;flex-shrink:0}
.brand__logo{width:40px;height:40px;border-radius:50%;object-fit:contain;padding:2px;background:#fff;border:1px solid rgba(16,46,84,.12);flex:none}
.brand__text{display:flex;flex-direction:column;line-height:1.15}
.brand__name{font-weight:800;font-size:18px;color:var(--ink);letter-spacing:-.02em}
.brand__sub{font-size:12px;color:var(--mut)}

.app-nav{display:flex;align-items:center;gap:8px}
.app-nav__link{min-height:44px;padding:0 12px;border-radius:10px;display:inline-flex;align-items:center;font-size:13px;font-weight:500;color:var(--mut);transition:color .15s,background .15s;white-space:nowrap}
.app-nav__link:hover{color:var(--ink);background:var(--card-2)}
.app-nav__link.is-active{color:var(--pri);font-weight:700}

.app-user{display:flex;align-items:center;gap:10px;flex-shrink:0}
.theme-circle{width:44px;height:44px;border-radius:999px;background:var(--bg);color:var(--ink);border:1px solid var(--line);display:inline-flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.theme-circle:hover{background:var(--soft);color:var(--pri)}
.av{width:38px;height:38px;border-radius:999px;background:var(--soft);color:var(--pri);display:grid;place-items:center;font-weight:700;font-size:12px;flex-shrink:0;overflow:hidden}
.av img{width:100%;height:100%;object-fit:cover;display:block}
.app-user__meta{display:flex;flex-direction:column;line-height:1.2}
.app-user__name{font-size:13px;font-weight:600;color:var(--ink)}
.app-user__role{font-size:12px;color:var(--mut)}
.logout-btn{min-height:44px;padding:0 14px;border-radius:10px;background:var(--badbg);color:var(--badtx);font-size:12px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;white-space:nowrap}
.logout-btn:hover{filter:brightness(.96)}

/* Main Container & Footer */
main.app-container{width:100%;padding:28px clamp(16px,2.5vw,32px) 40px;display:flex;flex-direction:column;gap:22px;flex:1;min-width:0}
footer.app-footer{width:100%;padding:16px clamp(16px,2.5vw,32px);color:var(--mut);font-size:12px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px;border-top:1px solid var(--line-soft);background:var(--card)}
.view{display:flex;flex-direction:column;gap:22px;min-width:0}

h1{font-size:clamp(22px,2.2vw,26px);font-weight:700;line-height:1.25;color:var(--ink);letter-spacing:-.02em}
h2{font-size:16px;font-weight:700;color:var(--ink)}
.sub{color:var(--mut);font-size:13px;line-height:1.5;margin-top:4px}
.ps{color:var(--mut);font-size:12px;margin-top:4px}
.top{display:flex;gap:14px;align-items:center;justify-content:space-between;flex-wrap:wrap}

/* Cards & Grids */
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:22px;display:flex;flex-direction:column;gap:16px;min-width:0}
.card.sh{box-shadow:0 3px 12px rgba(24,59,96,.05)}
.g2{display:grid;grid-template-columns:1.5fr 1fr;gap:16px}
.g2.eq{grid-template-columns:repeat(2,minmax(0,1fr))}
.g3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.g4{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px}
.g2>*,.g3>*,.g4>*,.mt>*,.mt4>*{min-width:0}

/* Asymmetric Hero Band & Proportional Tier Cards */
.hero-band{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1.35fr);gap:16px;align-items:stretch}
.hero-summary{background:var(--card);border:1px solid var(--line);border-radius:16px;padding:22px;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:20px;align-items:center}
.hero-metric{display:flex;align-items:center;justify-content:space-between;gap:14px}
.hero-metric__lbl{font-size:12px;font-weight:500;color:var(--mut)}
.hero-metric__val{font-size:28px;font-weight:800;color:var(--ink);line-height:1.15;margin:4px 0}
.hero-metric__sub{font-size:12px;color:var(--mut)}
.kelopak-ring{width:64px;height:64px;position:relative;flex-shrink:0}
.kelopak-ring span{position:absolute;width:14px;height:14px;border-radius:50%}

.tier-grid{display:grid;grid-template-columns:1.25fr 1fr .88fr;gap:12px}
.tier-card{border-radius:16px;padding:18px;display:flex;flex-direction:column;justify-content:space-between;gap:18px;min-height:164px}
.tier-card--ok{background:var(--tier-ok);color:var(--tier-on-ok)}
.tier-card--wait{background:var(--tier-wait);color:var(--tier-on-wait)}
.tier-card--bad{background:var(--tier-bad);color:var(--tier-on-bad)}
.tier-card__top{display:flex;align-items:center;justify-content:space-between;gap:8px;font-size:13px;font-weight:600}
.tier-card__badge{width:30px;height:30px;border-radius:50%;background:rgba(255,255,255,.26);display:grid;place-items:center;font-size:15px}
.tier-card__val{font-size:28px;font-weight:800;line-height:1.1}
.tier-card__sub{font-size:12px;font-weight:500;opacity:.92;margin-top:2px}

/* Page Header Context (Avatar stack + alert pill) */
.ctx-group{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.avatar-stack{display:flex;align-items:center}
.avatar-stack .av{width:32px;height:32px;border:2px solid var(--card);margin-left:-8px}
.avatar-stack .av:first-child{margin-left:0}
.alert-pill{min-height:36px;padding:6px 14px;border-radius:999px;background:var(--waitbg);color:var(--waittx);font-size:12px;font-weight:600;display:inline-flex;align-items:center;gap:6px}

/* Color-Tinted Horizontal Rows (Proficiency / Activity / Verification) */
.tinted-list{display:flex;flex-direction:column;gap:10px}
.tinted-row{border-radius:12px;padding:12px 16px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap}
.tinted-row--ok{background:var(--okbg)}
.tinted-row--wait{background:var(--waitbg)}
.tinted-row--bad{background:var(--badbg)}
.tinted-row--soft{background:var(--card-2);border:1px solid var(--line-soft)}
.tinted-row__id{display:flex;align-items:center;gap:12px;min-width:200px;flex:1}
.tinted-row__name{font-size:14px;font-weight:600;color:var(--ink)}
.tinted-row__sub{font-size:12px;color:var(--mut)}
.prog-track{width:200px;height:34px;border-radius:8px;background:var(--card);padding:0 10px;display:flex;align-items:center;gap:10px;flex-shrink:0}
.prog-track__bar{flex:1;height:12px;background:var(--bg);border-radius:4px;overflow:hidden}
.prog-track__fill{height:100%;border-radius:4px}
.prog-track__pct{font-size:12px;font-weight:700;color:var(--ink);min-width:34px;text-align:right}
.bubble-group{display:flex;align-items:center;gap:8px;flex-shrink:0}
.bubble{border-radius:50%;display:grid;place-items:center;font-size:12px;font-weight:700}
.bubble--ok{width:34px;height:34px;background:var(--tier-ok);color:var(--tier-on-ok)}
.bubble--wait{width:28px;height:28px;background:var(--tier-wait);color:var(--tier-on-wait)}
.bubble--bad{width:26px;height:26px;background:var(--tier-bad);color:var(--tier-on-bad)}

/* 7-Habit Bars & Stacked Class Bars */
.habit-bars{display:flex;flex-direction:column;gap:10px}
.habit-bar-row{display:grid;grid-template-columns:240px 1fr 44px;gap:12px;align-items:center}
.habit-bar-row__lbl{font-size:12px;font-weight:500;color:var(--ink)}
.habit-bar-row__trk{height:14px;background:var(--bg);border-radius:6px;overflow:hidden}
.habit-bar-row__fill{height:100%;border-radius:6px}
.habit-bar-row__pct{font-size:12px;font-weight:700;color:var(--ink);text-align:right}
.stacked-track{height:14px;background:var(--bg);border-radius:6px;overflow:hidden;display:flex;gap:2px}
.stacked-seg{height:100%;border-radius:3px}

/* Buttons, Date Pill, Stat Cards */
.btn{background:var(--pri);color:#fff;border-radius:10px;min-height:44px;padding:10px 18px;font-weight:600;font-size:13px;display:inline-flex;gap:8px;align-items:center;justify-content:center;white-space:nowrap}
[data-theme="dark"] .btn{color:#0B1828}
.btn:hover{filter:brightness(1.06)}
.btn.o{background:var(--card);color:var(--ink);border:1px solid var(--line)}
.btn.ok{background:var(--ok);color:#fff}
.btn.bad{background:var(--bad);color:#fff}
.btn.s{min-height:44px;padding:8px 14px;font-size:12px}
.btn.sm{min-height:44px;padding:0 16px;font-size:12px}
.btn svg{font-size:16px;color:currentColor}

.date{background:var(--card);border:1px solid var(--line);border-radius:10px;min-height:44px;padding:8px 14px;display:inline-flex;gap:8px;align-items:center;font-weight:600;font-size:12px}
.row{display:flex;gap:14px;align-items:center}
.stat{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:18px;display:flex;flex-direction:column;gap:10px}
.stat>div{display:flex;justify-content:space-between;align-items:center;color:var(--mut);font-size:12px}
.stat b{font-size:26px;font-weight:700;color:var(--ink)}
.stat small{color:var(--mut)}
.ib{width:38px;height:38px;border-radius:10px;background:var(--soft);color:var(--pri);display:grid;place-items:center;font-size:18px;flex-shrink:0}
.mt{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.mt>div,.mt4>div{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:18px;display:flex;gap:12px;align-items:center}
.mt4{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px}
.mt .ib,.mt4 .ib{width:40px;height:40px;border-radius:50%}
.mt small,.mt4 small{color:var(--mut);display:block;margin-bottom:2px}
.mt b,.mt4 b{font-size:22px;font-weight:700}

/* Charts */
.plot{display:flex;gap:12px}
.ylab{display:flex;flex-direction:column;justify-content:space-between;height:150px;color:var(--mut);font-size:12px;width:30px}
.bars{flex:1;display:flex;flex-direction:column;gap:10px}
.pl{height:150px;position:relative;display:flex;align-items:flex-end;justify-content:space-around;background:linear-gradient(var(--line-soft) 1px,transparent 1px) 0 4px/100% 48px}
.pl i{width:28px;background:var(--chart-bar);border-radius:5px 5px 0 0;display:block}
.pl i:last-child,.pl i.hi{background:var(--chart-hi)}
.days{display:flex;justify-content:space-around;color:var(--mut);font-size:12px}
.act{display:flex;gap:12px;align-items:center;padding:12px;border-radius:10px;background:var(--card-2);width:100%;text-align:left;min-height:44px}
.act:hover{background:var(--soft)}
.act .c{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;font-size:16px;flex-shrink:0}
.act div:nth-child(2){flex:1;display:flex;flex-direction:column;gap:2px;font-weight:600;font-size:13px}
.act small{color:var(--mut);font-weight:400}

/* Forms & Controls */
.ctl{position:relative;display:block}
.ctl input,.ctl select,.ctl textarea{width:100%;height:46px;border:1px solid var(--line);border-radius:10px;background:var(--card);color:var(--ink);padding:0 14px;font-size:13px;appearance:none}
.ctl textarea{height:auto;min-height:92px;padding:12px 14px}
.ctl select{padding-right:36px;text-overflow:ellipsis}
.ctl svg{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:16px;color:var(--mut);pointer-events:none}
.fld{display:flex;flex-direction:column;gap:6px;flex:1;min-width:0}
.fld>label{font-weight:600;font-size:12px;color:var(--ink)}
input::placeholder,textarea::placeholder{color:var(--mut)}

/* Tables, Status Chips, Tabs & Styled Laravel Pagination */
.tw{width:100%;max-width:100%;overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;min-width:560px}
th{background:var(--card-2);color:var(--ink);text-align:left;font-weight:600;font-size:12px;padding:13px 12px}
th:first-child{border-radius:10px 0 0 10px}th:last-child{border-radius:0 10px 10px 0}
td{padding:14px 12px;font-size:12px;line-height:1.45;border-bottom:1px solid var(--line-soft);color:var(--ink)}
tbody tr:last-child td{border:0}
.nm{display:flex;align-items:center;justify-content:space-between;gap:12px}.nm .av{width:34px;height:34px}
.pill{display:inline-flex;align-items:center;min-height:22px;padding:3px 10px;border-radius:6px;color:#fff;font-size:12px;font-weight:600;line-height:1;white-space:nowrap}
.pill--ok{background:var(--ok);color:#fff}
.pill--wait{background:#5A6D88;color:#fff}
.pill--bad{background:var(--bad);color:#fff}
[data-theme="dark"] .pill--ok{background:var(--tier-ok);color:#0B1828}
[data-theme="dark"] .pill--wait{background:#98A8BC;color:#0B1828}
[data-theme="dark"] .pill--bad{background:var(--tier-bad);color:#0B1828}

.ic{display:flex;gap:8px;font-size:16px}
.ic .e,.ic .d{min-width:44px;min-height:44px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center}
.ic .e{color:var(--pri);background:var(--soft)}.ic .d{color:var(--bad);background:var(--badbg)}
.tabs{display:flex;gap:24px;border-bottom:1px solid var(--line)}
.tab{min-height:44px;padding:10px 0;font-size:13px;color:var(--mut);border-bottom:2px solid transparent;display:inline-flex;align-items:center}
.tab.on{color:var(--pri);border-color:var(--pri);font-weight:600}

/* Styled Laravel Default Pagination (no Tailwind dependency) */
nav[role="navigation"]{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:8px}
nav[role="navigation"] svg{width:18px;height:18px}
nav[role="navigation"] a,nav[role="navigation"] span[aria-current="page"]>span,nav[role="navigation"] span[aria-disabled="true"]>span{min-width:44px;min-height:44px;padding:0 12px;border-radius:10px;border:1px solid var(--line);background:var(--card);color:var(--ink);font-size:12px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;gap:4px}
nav[role="navigation"] span[aria-current="page"]>span{background:var(--pri);color:#fff;border-color:var(--pri)}
[data-theme="dark"] nav[role="navigation"] span[aria-current="page"]>span{color:#0B1828}
nav[role="navigation"]>div:first-child{display:flex;gap:8px}
nav[role="navigation"]>div:last-child{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;width:100%}
nav[role="navigation"]>div:last-child>div:last-child>span{display:inline-flex;gap:6px;flex-wrap:wrap}

.info{background:var(--soft);border:1px solid var(--line);border-radius:14px;padding:16px;display:flex;gap:12px;font-size:12px;line-height:1.6}
.info svg{font-size:20px;color:var(--pri);margin-top:2px}.info p{color:var(--mut)}
.note{background:var(--soft);border-radius:10px;padding:14px;display:flex;gap:12px;font-size:12px;line-height:1.5;align-items:flex-start}
.note svg{font-size:18px;color:var(--pri);flex-shrink:0}

/* Switch, Badge, Settings */
.sw{position:relative;flex-shrink:0;width:44px;height:44px;display:inline-flex;align-items:center}
.sw input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;margin:0;z-index:1}
.sw s{position:relative;width:44px;height:24px;background:var(--line);border-radius:99px;transition:.2s;display:block}
.sw s:after{content:"";position:absolute;left:3px;top:3px;width:18px;height:18px;background:#fff;border-radius:50%;transition:.2s}
.sw input:checked+s{background:var(--pri)}.sw input:checked+s:after{transform:translateX(20px)}
.opt{display:flex;gap:16px;align-items:center;min-height:44px}.opt>div{flex:1;display:flex;flex-direction:column;gap:2px}.opt b{font-weight:600;font-size:13px}.opt small{color:var(--mut)}
.bi{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;color:#fff;font-size:17px;flex-shrink:0}
.lg{background:var(--card-2);border:1px solid var(--line);border-radius:14px;padding:16px;display:flex;flex-direction:column;gap:14px}
.lg .bi{width:44px;height:44px;font-size:20px}
.set{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:18px;display:flex;flex-direction:column;gap:12px}
.set .hd{display:flex;gap:10px;align-items:center}.hd small{color:var(--mut);display:block}
.set .r2{display:flex;gap:10px}
.nl>.opt{padding:10px 0;border-bottom:1px solid var(--line-soft)}.nl>.opt:last-child{border:0}
.pd{background:var(--okbg);color:var(--oktx);border-radius:10px;padding:10px 14px;display:flex;flex-direction:column;gap:4px;font-size:12px;min-width:240px}
.bar{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:14px 20px;display:flex;gap:16px;align-items:center}
.bar>div{flex:1}.bar b{font-weight:600;display:block;margin-bottom:2px;font-size:13px}.bar small{color:var(--mut)}
.toast{position:fixed;bottom:92px;right:20px;background:var(--ink);color:var(--card);padding:12px 18px;border-radius:10px;opacity:0;transform:translateY(8px);transition:.25s;pointer-events:none;z-index:95;font-size:12px;font-weight:600}.toast.on{opacity:1;transform:none}

/* Modals & Accessible Mobile Bottom Nav + Sheet */
.modal-backdrop,.sheet-backdrop{position:fixed;inset:0;z-index:75;background:rgba(11,24,40,.58);display:none;align-items:center;justify-content:center;padding:16px}
.modal-backdrop.is-open,.sheet-backdrop.is-open{display:flex}
.sheet-backdrop{align-items:flex-end;padding:0}
.sheet-panel{width:100%;max-width:480px;margin:0 auto;background:var(--card);border-radius:18px 18px 0 0;padding:20px 16px calc(20px + env(safe-area-inset-bottom));display:flex;flex-direction:column;gap:10px;border-top:1px solid var(--line)}
.sheet-link{min-height:48px;padding:0 14px;border-radius:12px;background:var(--card-2);color:var(--ink);font-size:14px;font-weight:600;display:flex;align-items:center;gap:12px}
.sheet-link.is-active{background:var(--soft);color:var(--pri)}

.bottom-nav{display:none;position:fixed;bottom:0;left:0;right:0;z-index:50;background:var(--card);border-top:1px solid var(--line);grid-template-columns:repeat(4,1fr);padding:6px 8px calc(6px + env(safe-area-inset-bottom))}
.bottom-nav__item{min-height:48px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:3px;font-size:12px;font-weight:600;color:var(--mut);border-radius:10px}
.bottom-nav__item.is-active{color:var(--pri)}
.bottom-nav__item svg{font-size:18px}

/* Breakpoint 1: Tablet & Small Laptop (640px - 1023px) */
@media(max-width:1023px){
  .app-nav{display:none}
  .bottom-nav{display:grid}
  main.app-container{padding-bottom:calc(96px + env(safe-area-inset-bottom))}
  .hero-band{grid-template-columns:1fr}
  .g2,.g2.eq{grid-template-columns:1fr}
  .g4,.mt4{grid-template-columns:repeat(2,minmax(0,1fr))}
  .habit-bar-row{grid-template-columns:180px 1fr 44px}
}

/* Breakpoint 2: Mobile Phone (< 640px) */
@media(max-width:639px){
  .app-header{min-height:68px}
  .app-user__meta,.app-header .logout-btn{display:none}
  .hero-summary{grid-template-columns:1fr}
  .tier-grid{grid-template-columns:1fr}
  .tier-card{min-height:112px;gap:12px}
  .g3,.mt,.g4,.mt4{grid-template-columns:1fr}
  .set .r2,.row{flex-direction:column;align-items:stretch}
  .habit-bar-row{grid-template-columns:1fr;gap:6px}
  .habit-bar-row__pct{text-align:left}
  .prog-track{width:100%}
  .pd{width:100%}
  nav[role="navigation"]>div:first-child{display:none}
}
@media(prefers-reduced-motion:reduce){*{transition:none!important}}
</style>
<script>
(function(){
  try {
    if (localStorage.getItem('g7kaih-theme') === 'dark') {
      document.documentElement.setAttribute('data-theme', 'dark');
    }
  } catch (e) {}
})();
</script>
