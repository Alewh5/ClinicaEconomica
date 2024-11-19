import{u as x,r as h,c as r,a as e,b as v,w,d as a,e as n,f as d,v as p,n as c,l as _,x as y,k as V,F as M,g as z,h as i}from"./index-4e15c3bc.js";import{s as C}from"./function-a3ead419.js";import{x as A}from"./index-95dfd304.js";import"./sweetalert2.all-4f88cff0.js";const k={class:"flex justify-between items-center"},H=e("h3",{class:"sm:text-2xl text-lg font-semibold text-gray-700"}," Cargar o Descargar Presupuesto ",-1),B={class:"flex flex-col items-start w-26 sm:flex-row sm:items-center"},S=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-box-arrow-left h-4 w-4 mr-2",viewBox:"0 0 16 16"},[e("path",{"fill-rule":"evenodd",d:"M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"}),e("path",{"fill-rule":"evenodd",d:"M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"})],-1),T=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-floppy-fill h-4 w-4 mr-2",viewBox:"0 0 16 16"},[e("path",{d:"M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"}),e("path",{d:"M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"})],-1),j={class:"mt-6"},D={class:"px-4 pb-8 pt-5 bg-white shadow-md"},F={class:"grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"},N={class:"text-gray-700",for:"fecha"},P={key:0,class:"text-red-500 mt-1 text-sm"},U={class:"flex mt-2"},L=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-calendar-check pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"}),e("path",{d:"M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"})])],-1),q={class:"text-gray-700",for:"tipoMovimiento"},E={key:0,class:"text-red-500 mt-1 text-sm"},O={class:"flex mt-2"},R=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-check2-square pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"}),e("path",{d:"m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"})])],-1),G=e("option",{value:"1"},"Cargar",-1),I=e("option",{value:"0"},"Retirar",-1),Z=[G,I],$={class:"text-gray-700",for:"concepto"},J={key:0,class:"text-red-500 mt-1 text-sm"},K={class:"flex mt-2"},Q=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83"})])],-1),W={class:"text-gray-700",for:"monto"},X={key:0,class:"text-red-500 mt-1 text-sm"},Y={class:"flex mt-2"},ee=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-currency-dollar pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73z"})])],-1),re={__name:"Create",setup(te){const u=x();axios.defaults.headers.common.Authorization="Bearer "+u.authToken;const f=u.authCompany.id,o=h({company_id:f,fecha:new Date().toISOString().split("T")[0],tipoMovimiento:1,concepto:"",monto:""}),s=h({}),g=async()=>{const{status:m,list_errors:t}=await C("POST",o.value,"/budgets","/budgets");m==422&&(s.value=t)};return(m,t)=>{const b=z("router-link");return i(),r(M,null,[e("div",k,[H,e("div",B,[v(b,{class:"inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-green-600 transition ease-in-out delay-75 hover:bg-green-700 text-white font-medium rounded-md",to:"/budgets"},{default:w(()=>[S,a(" Presupuestos ")]),_:1}),e("button",{onClick:g,class:"inline-flex items-center text-xs mt-1 sm:mt-0 w-full px-2 h-8 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white font-medium rounded-md"},[T,a(" Guardar ")])])]),e("div",j,[e("div",D,[e("form",null,[e("div",F,[e("div",null,[e("label",N,[a("Fecha "),s.value.fecha?(i(),r("span",P,"*")):n("",!0)]),e("div",U,[L,d(e("input",{type:"date",class:c(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":s.value.fecha}]),id:"fecha","onUpdate:modelValue":t[0]||(t[0]=l=>o.value.fecha=l),autocomplete:"off"},null,2),[[p,o.value.fecha]])])]),e("div",null,[e("label",q,[a("Tipo Movimiento "),s.value.tipoMovimiento?(i(),r("span",E,"*")):n("",!0)]),e("div",O,[R,d(e("select",{class:c(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":s.value.tipoMovimiento}]),id:"tipoMovimiento","onUpdate:modelValue":t[1]||(t[1]=l=>o.value.tipoMovimiento=l)},Z,2),[[_,o.value.tipoMovimiento]])])]),e("div",null,[e("label",$,[a("Concepto "),s.value.concepto?(i(),r("span",J,"*")):n("",!0)]),e("div",K,[Q,d(e("input",{type:"text",class:c(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":s.value.concepto}]),id:"concepto","onUpdate:modelValue":t[2]||(t[2]=l=>o.value.concepto=l),autocomplete:"off"},null,2),[[p,o.value.concepto]])])]),e("div",null,[e("label",W,[a("Monto "),s.value.monto?(i(),r("span",X,"*")):n("",!0)]),e("div",Y,[ee,v(V(A),y({type:"text",class:"w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2},{class:{"border-red-500 border-2":s.value.monto},id:"monto",modelValue:o.value.monto,"onUpdate:modelValue":t[3]||(t[3]=l=>o.value.monto=l),autocomplete:"off"}),null,16,["class","modelValue"])])])])])])])],64)}}};export{re as default};