var HotelierLucide=(()=>{var u={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":2,"stroke-linecap":"round","stroke-linejoin":"round"};var B=([e,t,a])=>{let r=document.createElementNS("http://www.w3.org/2000/svg",e);return Object.keys(t).forEach(o=>{r.setAttribute(o,String(t[o]))}),a?.length&&a.forEach(o=>{let s=B(o);r.appendChild(s)}),r},M=(e,t={})=>{let r={...u,...t};return B(["svg",r,e])};var L=e=>Array.from(e.attributes).reduce((t,a)=>(t[a.name]=a.value,t),{}),y=e=>typeof e=="string"?e:!e||!e.class?"":e.class&&typeof e.class=="string"?e.class.split(" "):e.class&&Array.isArray(e.class)?e.class:"",R=e=>e.flatMap(y).map(a=>a.trim()).filter(Boolean).filter((a,r,o)=>o.indexOf(a)===r).join(" "),T=e=>e.replace(/(\w)(\w*)(_|-|\s*)/g,(t,a,r)=>a.toUpperCase()+r.toLowerCase()),d=(e,{nameAttr:t,icons:a,attrs:r})=>{let o=e.getAttribute(t);if(o==null)return;let s=T(o),f=a[s];if(!f)return console.warn(`${e.outerHTML} icon name was not found in the provided icons object.`);let l=L(e),P={...u,"data-lucide":o,...r,...l},A=R(["lucide",`lucide-${o}`,l,r]);A&&Object.assign(P,{class:A});let D=M(f,P);return e.parentNode?.replaceChild(D,e)};var p=[["path",{d:"M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"}],["rect",{width:"20",height:"14",x:"2",y:"6",rx:"2"}]];var m=[["path",{d:"M20 6 9 17l-5-5"}]];var x=[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"}],["path",{d:"M12 18V6"}]];var i=[["path",{d:"M12 6v6l4 2"}],["circle",{cx:"12",cy:"12",r:"10"}]];var n=[["circle",{cx:"12",cy:"12",r:"10"}],["path",{d:"M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"}],["path",{d:"M2 12h20"}]];var c=[["path",{d:"m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"}],["rect",{x:"2",y:"4",width:"20",height:"16",rx:"2"}]];var C=[["path",{d:"M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"}],["circle",{cx:"12",cy:"10",r:"3"}]];var h=[["rect",{width:"20",height:"14",x:"2",y:"3",rx:"2"}],["line",{x1:"8",x2:"16",y1:"21",y2:"21"}],["line",{x1:"12",x2:"12",y1:"17",y2:"21"}]];var S=[["path",{d:"M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"}]];var g=[["path",{d:"M16 7h6v6"}],["path",{d:"m22 7-8.5 8.5-5-5L2 17"}]];var w=[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"}],["path",{d:"M16 3.128a4 4 0 0 1 0 7.744"}],["path",{d:"M22 21v-2a4 4 0 0 0-3-3.87"}],["circle",{cx:"9",cy:"7",r:"4"}]];var k=({icons:e={},nameAttr:t="data-lucide",attrs:a={},root:r=document,inTemplates:o}={})=>{if(!Object.values(e).length)throw new Error(`Please provide an icons object.
If you want to use all the icons you can import it like:
 \`import { createIcons, icons } from 'lucide';
lucide.createIcons({icons});\``);if(typeof r>"u")throw new Error("`createIcons()` only works in a browser environment.");if(Array.from(r.querySelectorAll(`[${t}]`)).forEach(f=>d(f,{nameAttr:t,icons:e,attrs:a})),o&&Array.from(r.querySelectorAll("template")).forEach(l=>k({icons:e,nameAttr:t,attrs:a,root:l.content,inTemplates:o})),t==="data-lucide"){let f=r.querySelectorAll("[icon-name]");f.length>0&&(console.warn("[Lucide] Some icons were found with the now deprecated icon-name attribute. These will still be replaced for backwards compatibility, but will no longer be supported in v1.0 and you should switch to data-lucide"),Array.from(f).forEach(l=>d(l,{nameAttr:"icon-name",icons:e,attrs:a})))}};function F(){k({icons:{Briefcase:p,Check:m,CircleDollarSign:x,Clock:i,Globe:n,Mail:c,MapPin:C,Monitor:h,Phone:S,TrendingUp:g,Users:w},attrs:{"stroke-width":"1.75","stroke-linecap":"round","stroke-linejoin":"round"}})}document.readyState==="loading"?document.addEventListener("DOMContentLoaded",F):F();})();
/*! Bundled license information:

lucide/dist/esm/defaultAttributes.js:
lucide/dist/esm/createElement.js:
lucide/dist/esm/replaceElement.js:
lucide/dist/esm/icons/briefcase.js:
lucide/dist/esm/icons/check.js:
lucide/dist/esm/icons/circle-dollar-sign.js:
lucide/dist/esm/icons/clock.js:
lucide/dist/esm/icons/globe.js:
lucide/dist/esm/icons/mail.js:
lucide/dist/esm/icons/map-pin.js:
lucide/dist/esm/icons/monitor.js:
lucide/dist/esm/icons/phone.js:
lucide/dist/esm/icons/trending-up.js:
lucide/dist/esm/icons/users.js:
lucide/dist/esm/lucide.js:
  (**
   * @license lucide v0.562.0 - ISC
   *
   * This source code is licensed under the ISC license.
   * See the LICENSE file in the root directory of this source tree.
   *)
*/
