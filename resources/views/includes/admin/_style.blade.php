<style>
:root{--side:#17324f;--ink:#102e54;--mut:#6f83a0;--line:#dfeaf5;--bg:#f4f8fc;--pri:#247ef2;--nav:#0969aa;--soft:#eaf4ff;--ok:#07805d;--okbg:#e9f6f1;--wait:#94600a;--bad:#c52d49;--navtx:#b9d0e7}
*{box-sizing:border-box;margin:0}
body{font-family:Inter,system-ui,sans-serif;background:var(--bg);color:var(--ink);display:flex;min-height:100vh;font-size:12px}
button,input,select{font:inherit;color:inherit}button{cursor:pointer;border:0;background:none}
svg.i{width:1em;height:1em;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
:focus-visible{outline:2px solid var(--pri);outline-offset:2px}
/* sidebar */
aside{width:224px;background:var(--side);padding:28px 18px;display:flex;flex-direction:column;gap:34px;flex-shrink:0;position:sticky;top:0;height:100vh}
.brand{display:flex;gap:9px;align-items:center}.brand b{display:block;color:#fff;font-size:17px;font-weight:800}.brand small{color:var(--navtx);font-size:9px}
nav{display:flex;flex-direction:column;gap:7px}
.nv{display:flex;gap:10px;align-items:center;padding:13px 12px;border-radius:6px;color:var(--navtx);font-size:11px;text-align:left;width:100%}
.nv svg{font-size:17px}.nv:hover{background:#ffffff12}.nv.on{background:var(--nav);color:#fff;font-weight:600}
.sch{margin-top:0;border-top:1px solid #ffffff17;padding:12px;color:var(--navtx);display:flex;flex-direction:column;gap:8px;font-size:11px}.sch small{font-size:10px}
.area{flex:1;min-width:0;display:flex;flex-direction:column}
header{background:#fff;height:80px;padding:0 32px;display:flex;align-items:center;justify-content:space-between}
header>b{font-size:13px;font-weight:600}.acc{display:flex;gap:12px;align-items:center}.acc svg{font-size:20px;color:var(--mut)}
.av{border-radius:50%;background:var(--soft);color:var(--pri);display:grid;place-items:center;font-weight:700;flex-shrink:0}
.acc .av{width:34px;height:34px}.acc small{display:block;color:var(--mut);font-size:10px;margin-top:3px}.acc strong{font-size:12px;font-weight:600}
main{padding:32px;display:flex;flex-direction:column;gap:24px;flex:1}
footer{padding:16px 32px;color:var(--mut);font-size:10px;display:flex;justify-content:space-between}
.view{display:none;flex-direction:column;gap:24px}.view.on{display:flex}
h1{font-size:27px;font-weight:700;line-height:1.25}.sub{color:var(--mut);font-size:13px;line-height:1.5;margin-top:5px}
.top{display:flex;gap:16px;align-items:center;justify-content:space-between;flex-wrap:wrap}
.card{background:#fff;border-radius:10px;padding:24px;display:flex;flex-direction:column;gap:18px}
.card.sh{box-shadow:0 3px 12px #183b600f}.card.bd{border:1px solid var(--line)}
h2{font-size:15px;font-weight:700}.ps{color:var(--mut);font-size:11px;margin-top:5px}
.btn{background:var(--pri);color:#fff;border-radius:6px;padding:11px 18px;font-weight:600;font-size:13px;display:inline-flex;gap:6px;align-items:center;justify-content:center;white-space:nowrap}
.btn:hover{filter:brightness(1.08)}.btn.o{background:#fff;color:var(--ink);border:1px solid var(--line);font-size:12px}.btn.s{padding:7px 10px;font-size:11px}.btn.sm{font-size:12px;padding:0 16px;height:39px}
.btn svg{font-size:16px}
.date{background:#fff;border:1px solid var(--line);border-radius:6px;padding:10px 14px;display:flex;gap:8px;align-items:center;font-weight:600}
.row{display:flex;gap:16px}.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}.g2{display:grid;grid-template-columns:1.55fr 1fr;gap:16px}
.stat{background:#fff;border-radius:10px;padding:20px;display:flex;flex-direction:column;gap:12px}
.stat>div{display:flex;justify-content:space-between;align-items:center;color:var(--mut)}.stat b{font-size:28px;font-weight:700}.stat small{color:var(--mut);font-size:11px}
.ib{width:32px;height:32px;border-radius:8px;background:var(--soft);color:var(--pri);display:grid;place-items:center;font-size:18px;flex-shrink:0}
.up{color:var(--ok)!important}
/* chart */
.plot{display:flex;gap:12px}.ylab{display:flex;flex-direction:column;justify-content:space-between;height:150px;color:var(--mut);font-size:10px;width:25px}
.bars{flex:1;display:flex;flex-direction:column;gap:10px}.pl{height:150px;position:relative;display:flex;align-items:flex-end;justify-content:space-around;background:linear-gradient(var(--line) 1px,transparent 1px) 0 4px/100% 48px}
.pl i{width:32px;background:#a9cdfb;border-radius:4px 4px 0 0}.pl i:last-child{background:var(--pri)}
.days{display:flex;justify-content:space-around;color:var(--mut);font-size:10px}
.seg{display:flex;gap:3px;height:9px;border-radius:99px;overflow:hidden}.seg i{display:block}
.st{display:flex;align-items:center;gap:8px;font-size:11px;color:var(--mut)}.st i{width:7px;height:7px;border-radius:50%}.st span{flex:1}.st b{color:var(--ink);font-size:12px;font-weight:600}.st em{font-style:normal;font-size:10px;width:44px;text-align:right}
.lnk{color:var(--pri);font-weight:600;font-size:11px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--line);padding-top:12px}
.act{display:flex;gap:12px;align-items:center;padding:12px 0;border-bottom:1px solid var(--line);width:100%;text-align:left}.act:last-child{border:0}
.act .c{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;font-size:16px;flex-shrink:0}.act .c.q{border-radius:6px;font-size:17px}
.act div:nth-child(2){flex:1;display:flex;flex-direction:column;gap:5px;font-weight:500}.act small{color:var(--mut);font-size:10px;font-weight:400}.act>span{color:var(--mut);font-size:10px}.act>svg{color:var(--mut)}
/* form */
.ctl{position:relative;display:block}
.ctl input,.ctl select{width:100%;height:40px;border:1px solid var(--line);border-radius:6px;background:#fff;padding:0 12px;font-size:12px;appearance:none}
.ctl svg{position:absolute;right:12px;top:50%;transform:translateY(-50%);font-size:16px;color:var(--mut);pointer-events:none}
.ctl.h28 input,.ctl.h28 select{height:32px}
input::placeholder{color:#98a8bc}
.fld{display:flex;flex-direction:column;gap:7px;flex:1;min-width:0}.fld>label{font-weight:600;font-size:12px}
.fld.m>label{font-weight:500}
/* table */
.tw{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:560px}
th{background:var(--bg);text-align:left;font-weight:600;font-size:11px;padding:13px 12px}th:first-child{border-radius:6px 0 0 6px}th:last-child{border-radius:0 6px 6px 0}
td{padding:15px 12px;font-size:11px;line-height:1.4;border-bottom:1px solid #e2e8f0}tbody tr:last-child td{border:0}
.nm{display:flex;align-items:center;justify-content:space-between;gap:12px}.nm .av{width:32px;height:32px;font-size:11px}
.pill{display:inline-block;padding:4px 8px;border-radius:99px;color:#fff;font-size:10px;font-weight:600}
.ic{display:flex;gap:8px;font-size:16px}.ic .e{color:var(--pri)}.ic .d{color:#e34557}
.tabs{display:flex;gap:24px;border-bottom:1px solid var(--line)}.tab{padding:12px 0;font-size:13px;color:var(--mut);border-bottom:2px solid transparent}.tab.on{color:var(--pri);border-color:var(--pri)}
.pg{display:flex;gap:6px}.pg button{width:26px;height:26px;border-radius:6px;background:#fff;color:var(--mut);font-size:11px}.pg button.on{background:var(--pri);color:#fff}
.info{background:var(--bg);border-radius:12px;padding:16px;display:flex;gap:12px;font-size:12px;line-height:1.6}.info svg{font-size:20px;color:var(--pri);margin-top:2px}.info p{color:var(--mut)}
.note{background:var(--soft);border-radius:6px;padding:14px;display:flex;gap:12px;font-size:12px;line-height:1.5;align-items:flex-start}.note svg{font-size:18px;color:var(--pri);flex-shrink:0}
.note.b{padding:6px 12px;gap:4px;color:var(--nav);font-size:11px;line-height:16px}.note.b svg{font-size:15px}
/* switch */
.sw{position:relative;flex-shrink:0;width:34px;height:20px}.sw.l{width:40px;height:24px}
.sw input{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer;margin:0;z-index:1}
.sw s{position:absolute;inset:0;background:#cfd9e6;border-radius:99px;transition:.2s}
.sw s:after{content:"";position:absolute;left:3px;top:3px;width:14px;height:14px;background:#fff;border-radius:50%;transition:.2s}
.sw.l s:after{width:18px;height:18px}.sw input:checked+s{background:var(--pri)}.sw input:checked+s:after{transform:translateX(14px)}.sw.l input:checked+s:after{transform:translateX(16px)}
.sw input:focus-visible+s{outline:2px solid var(--pri);outline-offset:2px}
.opt{display:flex;gap:16px;align-items:flex-start}.opt>div{flex:1;display:flex;flex-direction:column;gap:4px}.opt b{font-weight:500}.opt small{color:var(--mut);font-size:11px;line-height:16px}
/* badge */
.bi{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;color:#fff;font-size:17px;flex-shrink:0}
.lg{background:var(--bg);border-radius:10px;padding:16px;display:flex;flex-direction:column;gap:14px}
.lg .bi{width:44px;height:44px;font-size:20px}
.mt{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.mt>div{background:#fff;border-radius:10px;padding:18px;display:flex;gap:12px;align-items:center}.mt .ib{width:34px;height:34px;border-radius:50%}.mt small{color:var(--mut);font-size:10px;display:block;margin-bottom:3px}.mt b{font-size:23px;font-weight:700}
/* settings */
.set{background:#fff;border-radius:10px;padding:12px;display:flex;flex-direction:column;gap:8px}
.set .hd{display:flex;gap:6px;align-items:center}.set .hd .ib{width:34px;height:34px}.set .hd h2{margin-bottom:4px}
.hd small{color:var(--mut);font-size:11px;line-height:16px;display:block}
.set .ctl input,.set .ctl select{height:28px}.set .ctl.h32 input,.set .ctl.h32 select{height:32px}
.set .fld{gap:6px}.set .r2{display:flex;gap:8px}
.nl>.opt{padding:8px 0;border-bottom:1px solid var(--line)}.nl>.opt:last-child{border:0}
.pd{background:var(--okbg);color:var(--ok);border-radius:6px;padding:8px 12px;display:flex;flex-direction:column;gap:6px;font-size:11px;line-height:16px;width:300px}.pd b{font-weight:600}
.bar{background:#fff;border-radius:10px;padding:10px 20px;display:flex;gap:16px;align-items:center}.bar>div{flex:1}.bar b{font-weight:600;display:block;margin-bottom:4px}.bar small{color:var(--mut);font-size:11px}
.toast{position:fixed;bottom:22px;right:22px;background:var(--ink);color:#fff;padding:12px 18px;border-radius:8px;opacity:0;transform:translateY(8px);transition:.25s;pointer-events:none;z-index:9}.toast.on{opacity:1;transform:none}
@media(max-width:1000px){body{flex-direction:column}aside{width:100%;height:auto;position:static;flex-direction:row;padding:12px;gap:8px;overflow-x:auto;align-items:center}.brand small,.sch{display:none}nav{flex-direction:row}.nv{white-space:nowrap;padding:10px 12px;width:auto}
 main{padding:20px 16px}header{padding:0 16px}.g4,.g2,.mt{grid-template-columns:1fr 1fr}.g2{grid-template-columns:1fr}.row{flex-direction:column}.pd{width:auto}.mt{grid-template-columns:1fr}.set .r2{flex-direction:column}}
@media(max-width:560px){.g4{grid-template-columns:1fr}h1{font-size:23px}}
@media(prefers-reduced-motion:reduce){*{transition:none!important}}
a{color:inherit;text-decoration:none}
</style>
