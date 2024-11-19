import{u as Q,r as g,o as J,c as a,a as e,b as x,w as K,d as u,f as m,q as W,e as c,n as b,l as N,v as f,F as D,s as B,x as _,k as w,t as y,g as X,h as r,y as Y}from"./index-4e15c3bc.js";import{s as T}from"./function-a3ead419.js";import{x as V}from"./index-95dfd304.js";import{S as ee}from"./sweetalert2.all-4f88cff0.js";const te={class:"flex justify-between items-center"},oe=e("h3",{class:"sm:text-2xl text-lg font-semibold text-gray-700"}," Realizar Venta ",-1),le={class:"flex flex-col items-start w-26 sm:flex-row sm:items-center"},se=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-box-arrow-left h-4 w-4 mr-2",viewBox:"0 0 16 16"},[e("path",{"fill-rule":"evenodd",d:"M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"}),e("path",{"fill-rule":"evenodd",d:"M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"})],-1),ae=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-floppy-fill h-4 w-4 mr-2",viewBox:"0 0 16 16"},[e("path",{d:"M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"}),e("path",{d:"M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"})],-1),re={class:"mt-6"},ne={class:"px-4 py-4 bg-white shadow-md"},ie=e("hr",{class:"border w-full mr-2"},null,-1),de=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-caret-down",viewBox:"0 0 16 16"},[e("path",{d:"M3.204 5h9.592L8 10.481zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659"})],-1),ue=[ie,de],ce={class:"grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mt-2"},me={class:"text-gray-700",for:"tipoDocumento"},pe={key:0,class:"text-red-500 mt-1 text-sm"},be={class:"flex mt-2"},ve=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-check2-square pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"}),e("path",{d:"m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"})])],-1),he=Y('<option value="CC">Cédula Ciudadanía</option><option value="CE">Cedula Extranjera</option><option value="TI">Tarjeta Identidad</option><option value="NIT">Identificación Tributaria</option><option value="PB">Pasaporte</option>',5),ge=[he],fe={class:"text-gray-700",for:"numeroDocumento"},xe={key:0,class:"text-red-500 mt-1 text-sm"},_e={class:"flex mt-2"},we=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-hash pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M8.39 12.648a1 1 0 0 0-.015.18c0 .305.21.508.5.508.266 0 .492-.172.555-.477l.554-2.703h1.204c.421 0 .617-.234.617-.547 0-.312-.188-.53-.617-.53h-.985l.516-2.524h1.265c.43 0 .618-.227.618-.547 0-.313-.188-.524-.618-.524h-1.046l.476-2.304a1 1 0 0 0 .016-.164.51.51 0 0 0-.516-.516.54.54 0 0 0-.539.43l-.523 2.554H7.617l.477-2.304c.008-.04.015-.118.015-.164a.51.51 0 0 0-.523-.516.54.54 0 0 0-.531.43L6.53 5.484H5.414c-.43 0-.617.22-.617.532s.187.539.617.539h.906l-.515 2.523H4.609c-.421 0-.609.219-.609.531s.188.547.61.547h.976l-.516 2.492c-.008.04-.015.125-.015.18 0 .305.21.508.5.508.265 0 .492-.172.554-.477l.555-2.703h2.242zm-1-6.109h2.266l-.515 2.563H6.859l.532-2.563z"})])],-1),ye={class:"text-gray-700",for:"NombreRazonSocial"},Ve={key:0,class:"text-red-500 mt-1 text-sm"},Ce={class:"flex mt-2"},ze=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83"})])],-1),ke={class:"text-gray-700",for:"email"},Me={key:0,class:"text-red-500 mt-1 text-sm"},He={class:"flex mt-2"},Ae=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-envelope-at pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"}),e("path",{d:"M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"})])],-1),De={class:"text-gray-700",for:"telefono"},Pe={key:0,class:"text-red-500 mt-1 text-sm"},Be={class:"flex mt-2"},Se=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-telephone-plus-fill pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{"fill-rule":"evenodd",d:"M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zM12.5 1a.5.5 0 0 1 .5.5V3h1.5a.5.5 0 0 1 0 1H13v1.5a.5.5 0 0 1-1 0V4h-1.5a.5.5 0 0 1 0-1H12V1.5a.5.5 0 0 1 .5-.5"})])],-1),Ue=e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-floppy-fill h-4 w-4 mr-2",viewBox:"0 0 16 16"},[e("path",{d:"M0 1.5A1.5 1.5 0 0 1 1.5 0H3v5.5A1.5 1.5 0 0 0 4.5 7h7A1.5 1.5 0 0 0 13 5.5V0h.086a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5H14v-5.5A1.5 1.5 0 0 0 12.5 9h-9A1.5 1.5 0 0 0 2 10.5V16h-.5A1.5 1.5 0 0 1 0 14.5z"}),e("path",{d:"M3 16h10v-5.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5zm9-16H4v5.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5zM9 1h2v4H9z"})],-1),Ne={class:"mt-4"},Te={class:"px-4 pb-8 pt-5 bg-white shadow-md"},Ie={class:"grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"},$e={key:0,class:"relative"},je={class:"text-gray-700",for:"searchCustomer"},Ee={key:0,class:"text-red-500 mt-1 text-sm"},Fe={class:"flex mt-2"},Re=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-search-heart pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"}),e("path",{d:"M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"})])],-1),Le={key:0,class:"mt-4 absolute top-16 bg-white z-10 border rounded border-gray-300 w-full overflow-y-auto"},Oe={class:"font-medium"},Ge=["onClick"],qe={key:1},Ze={class:"text-gray-700",for:"customer_id"},Qe={key:0,class:"text-red-500 mt-1 text-sm"},Je={class:"flex mt-2"},Ke=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83"})])],-1),We={class:"text-gray-700",for:"codigo"},Xe={key:0,class:"text-red-500 mt-1 text-sm"},Ye={class:"flex mt-2"},et=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83"})])],-1),tt={class:"text-gray-700",for:"fechaEmision"},ot={key:0,class:"text-red-500 mt-1 text-sm"},lt={class:"flex mt-2"},st=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-alphabet-uppercase pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M1.226 10.88H0l2.056-6.26h1.42l2.047 6.26h-1.29l-.48-1.61H1.707l-.48 1.61ZM2.76 5.818h-.054l-.75 2.532H3.51zm3.217 5.062V4.62h2.56c1.09 0 1.808.582 1.808 1.54 0 .762-.444 1.22-1.05 1.372v.055c.736.074 1.365.587 1.365 1.528 0 1.119-.89 1.766-2.133 1.766zM7.18 5.55v1.675h.8c.812 0 1.171-.308 1.171-.853 0-.51-.328-.822-.898-.822zm0 2.537V9.95h.903c.951 0 1.342-.312 1.342-.909 0-.591-.382-.954-1.095-.954zm5.089-.711v.775c0 1.156.49 1.803 1.347 1.803.705 0 1.163-.454 1.212-1.096H16v.12C15.942 10.173 14.95 11 13.607 11c-1.648 0-2.573-1.073-2.573-2.849v-.78c0-1.775.934-2.871 2.573-2.871 1.347 0 2.34.849 2.393 2.087v.115h-1.172c-.05-.665-.516-1.156-1.212-1.156-.849 0-1.347.67-1.347 1.83"})])],-1),at={class:"text-gray-700",for:"metodoPago"},rt={key:0,class:"text-red-500 mt-1 text-sm"},nt={class:"flex mt-2"},it=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-check2-square pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5z"}),e("path",{d:"m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0"})])],-1),dt=e("option",{value:"Efectivo"},"Efectivo",-1),ut=e("option",{value:"Nequi"},"Nequi",-1),ct=e("option",{value:"Tarjeta"},"Tarjeta",-1),mt=e("option",{value:"Credito"},"Credito",-1),pt=[dt,ut,ct,mt],bt={class:"grid grid-cols-1 mt-6 sm:grid-cols-1 lg:grid-cols-2"},vt={class:"relative"},ht={class:"text-gray-700",for:"searchProduct"},gt={key:0,class:"text-red-500 mt-1 text-sm"},ft={class:"flex mt-2"},xt=e("div",{class:"flex items-center justify-center rounded-tl-lg rounded-bl-lg border-y border-l relative border-gray-400 bg-white p-5"},[e("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"currentColor",class:"bi bi-search-heart pointer-events-none absolute w-5 h-5 fill-gray-500 transition",viewBox:"0 0 16 16"},[e("path",{d:"M6.5 4.482c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018"}),e("path",{d:"M13 6.5a6.47 6.47 0 0 1-1.258 3.844q.06.044.115.098l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1-.1-.115h.002A6.5 6.5 0 1 1 13 6.5M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11"})])],-1),_t={key:0,class:"mt-4 absolute top-16 bg-white border rounded border-gray-300 w-full overflow-y-auto"},wt={class:"font-medium"},yt={class:"inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full"},Vt=["onClick"],Ct={class:"py-2 my-2 overflow-y-auto"},zt={class:"inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow rounded"},kt={class:"min-w-full overflow-x-auto",style:{"font-size":"0.6rem"}},Mt=e("thead",null,[e("tr",null,[e("th",{class:"px-1 py-2 font-bold leading-4 tracking-wider text-left text-white uppercase bg-gray-900 border-b border-gray-200"}," Productos "),e("th",{class:"px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Cantidad "),e("th",{class:"px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Precio Unitario "),e("th",{class:"px-1 py-2 w-20 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Descuento "),e("th",{class:"px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Valor Descuento "),e("th",{class:"px-1 py-2 w-24 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Impuestos "),e("th",{class:"px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Subtotal "),e("th",{class:"px-1 py-2 w-28 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Precio Total "),e("th",{class:"px-1 py-2 font-bold leading-4 tracking-wider text-center text-white uppercase bg-gray-900 border-b border-gray-200"}," Quitar ")])],-1),Ht={class:"bg-white"},At={class:"px-1 py-1 border-b border-gray-200"},Dt={class:"font-medium text-gray-900"},Pt={class:"text-gray-900 whitespace-normal"},Bt={class:"px-1 py-1 border-b border-gray-200 text-center"},St=["onUpdate:modelValue","onInput"],Ut={class:"px-1 py-1 border-b border-gray-200 text-center"},Nt={class:"px-1 py-1 border-b border-gray-200 text-center"},Tt={class:"px-1 py-1 border-b border-gray-200 text-center"},It={class:"px-1 py-1 border-b border-gray-200 text-center"},$t={class:"px-1 py-1 border-b border-gray-200 text-center"},jt={class:"px-1 py-1 border-b border-gray-200 text-center"},Et={class:"px-1 py-1 border-b border-gray-200 text-center"},Ft={class:"flex items-center justify-center"},Rt=["onClick"],Lt=e("svg",{xmlns:"http://www.w3.org/2000/svg",width:"16",height:"16",fill:"currentColor",class:"bi bi-trash3-fill",viewBox:"0 0 16 16"},[e("path",{d:"M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"})],-1),Ot=[Lt],Gt=e("td",{colspan:"3",class:"text-right font-semibold px-6 py-2 bg-white"},"Total:",-1),qt={class:"px-1 py-1 border-b border-gray-200 text-center"},Zt={class:"px-1 py-1 border-b border-gray-200 text-center"},Qt={class:"text-center font-semibold px-6 py-2 bg-white"},Jt={class:"text-center font-semibold px-6 py-2 bg-white"},Kt={class:"text-center font-semibold px-6 py-2 bg-white"},Wt=e("td",null,null,-1),lo={__name:"Create",setup(Xt){const I=Q();axios.defaults.headers.common.Authorization="Bearer "+I.authToken;const s=g({customer_id:"",codigo:"",fechaEmision:new Date().toISOString().split("T")[0],metodoPago:"Efectivo",subTotal:"",impuestos:"",total:"",descuento_global:0,valor_descuentoGlobal:0,descuento_total:"",products:[]}),H=g(!1),$=()=>{H.value=!H.value},p=g({tipoDocumento:"CC",numeroDocumento:"",NombreRazonSocial:"",email:"",telefono:""}),v=g({}),j=async()=>{const{status:l,list_errors:o,error:h,responseData:t}=await T("POST",p.value,"/customers","");l==422&&(v.value=o),l==201&&(s.value.customer_id=t.customer.id,A.value=t.customer,lime,H.value=!1,p.value={tipoDocumento:"CC",numeroDocumento:"",NombreRazonSocial:"",email:"",telefono:""})},E=async()=>{const l=await axios.get("/sales?page=1");if(l.data.data.length>0){const o=l.data.data[0].codigo.split("-")[1],h=o.length,t=`VTN-${(parseInt(o)+1).toString().padStart(h,"0")}`;s.value.codigo=t}else s.value.codigo="VTN-0001"};J(()=>{E()});const z=g([]),A=g({}),k=g(""),M=g(""),S=g([]),U=g([]),F=async()=>{const l=await axios.get(`/customers?search=${M.value}`);U.value=l.data.data},R=l=>{s.value.customer_id=l.id,A.value=l,M.value=""},L=async()=>{const l=await axios.get(`/searchProduct?search=${k.value}`);S.value=l.data},O=async l=>{const o=s.value.products.findIndex(h=>h.product_id===l.id);o!==-1?(s.value.products[o].cantidad++,await C(s.value.products[o])):(s.value.products.push({product_id:l.id,cantidad:1,precio_unitario:l.precio,descuento:0,valor_descuento:"",subtotal:"",impuestos:"",precio_total:""}),z.value.push({product_codigo:l.codigo,product_descripcion:l.descripcion,product_iva:l.iva_venta}),await C(s.value.products[s.value.products.length-1])),k.value=""},G=async l=>{s.value.products.splice(l,1),z.value.splice(l,1),await P(),await C(s.value.products[existingProductIndex])},P=async()=>{s.value.descuento_total=s.value.products.reduce((t,i)=>t+i.valor_descuento,0),s.value.impuestos=s.value.products.reduce((t,i)=>t+i.impuestos,0);const l=s.value.products.reduce((t,i)=>t+i.subtotal,0),o=s.value.descuento_global,h=l*(o/100);s.value.valor_descuentoGlobal=h,s.value.subTotal=l-h,s.value.total=s.value.subTotal+s.value.impuestos},C=async l=>{const o=s.value.products.indexOf(l);l.impuestos=l.cantidad*l.precio_unitario*z.value[o].product_iva/100,l.valor_descuento=l.cantidad*l.precio_unitario*l.descuento/100,l.subtotal=l.cantidad*l.precio_unitario-l.valor_descuento,l.precio_total=l.subtotal+l.impuestos,await P()},q=l=>{ee.fire({title:"Ingrese el monto a pagar",html:`
            <input id="monto" autocomplete="off"
            class="w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0">
            <div id="vuelto" class="text-gray-600 mt-2"></div>
        `,showCancelButton:!0,confirmButtonText:"Guardar",cancelButtonText:"Cancelar",didOpen:()=>{const o=document.getElementById("monto"),h=document.getElementById("vuelto");o.addEventListener("input",()=>{const t=parseFloat(o.value),i=parseFloat(l.total),d=t-i;h.textContent=d>=0?`Vuelto: ${d}`:"Monto insuficiente"})},preConfirm:()=>parseFloat(document.getElementById("monto").value)}).then(o=>{o.isConfirmed&&Z()})},n=g({}),Z=async()=>{const{status:l,list_errors:o}=await T("POST",s.value,"/sales","/sales");l==422&&(n.value=o)};return(l,o)=>{const h=X("router-link");return r(),a(D,null,[e("div",te,[oe,e("div",le,[x(h,{class:"inline-flex items-center text-xs mb-1 sm:mb-0 sm:mr-2 w-full px-2 h-8 bg-lime-500 transition ease-in-out delay-75 hover:bg-lime-700 text-white font-medium rounded-md",to:"/sales"},{default:K(()=>[se,u(" Ventas ")]),_:1}),e("button",{onClick:o[0]||(o[0]=t=>q(s.value)),class:"inline-flex items-center text-xs mt-1 sm:mt-0 w-full px-2 h-8 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white font-medium rounded-md"},[ae,u(" Guardar ")])])]),e("div",re,[e("div",ne,[e("button",{onClick:o[1]||(o[1]=t=>$()),class:"flex items-center justify-between w-full outline-none"},ue),m(e("form",null,[e("div",ce,[e("div",null,[e("label",me,[u("Tipo de DNI "),v.value.tipoDocumento?(r(),a("span",pe,"*")):c("",!0)]),e("div",be,[ve,m(e("select",{class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":v.value.tipoDocumento}]),id:"tipoDocumento","onUpdate:modelValue":o[2]||(o[2]=t=>p.value.tipoDocumento=t)},ge,2),[[N,p.value.tipoDocumento]])])]),e("div",null,[e("label",fe,[u("Documento "),v.value.numeroDocumento?(r(),a("span",xe,"*")):c("",!0)]),e("div",_e,[we,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":v.value.numeroDocumento}]),id:"numeroDocumento","onUpdate:modelValue":o[3]||(o[3]=t=>p.value.numeroDocumento=t),autocomplete:"off"},null,2),[[f,p.value.numeroDocumento]])])]),e("div",null,[e("label",ye,[u("Nombre / Razón Social "),v.value.NombreRazonSocial?(r(),a("span",Ve,"*")):c("",!0)]),e("div",Ce,[ze,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":v.value.NombreRazonSocial}]),id:"NombreRazonSocial","onUpdate:modelValue":o[4]||(o[4]=t=>p.value.NombreRazonSocial=t),autocomplete:"off"},null,2),[[f,p.value.NombreRazonSocial]])])]),e("div",null,[e("label",ke,[u("Email "),v.value.email?(r(),a("span",Me,"*")):c("",!0)]),e("div",He,[Ae,m(e("input",{type:"email",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":v.value.email}]),id:"email","onUpdate:modelValue":o[5]||(o[5]=t=>p.value.email=t),autocomplete:"off"},null,2),[[f,p.value.email]])])]),e("div",null,[e("label",De,[u("Teléfono "),v.value.telefono?(r(),a("span",Pe,"*")):c("",!0)]),e("div",Be,[Se,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":v.value.telefono}]),id:"telefono","onUpdate:modelValue":o[6]||(o[6]=t=>p.value.telefono=t),autocomplete:"off"},null,2),[[f,p.value.telefono]])])])]),e("button",{type:"button",onClick:o[7]||(o[7]=t=>j()),class:"flex items-center text-xs mt-4 w-24 px-2 h-8 bg-blue-600 transition ease-in-out delay-75 hover:bg-blue-700 text-white font-medium rounded-md"},[Ue,u(" Guardar ")])],512),[[W,H.value]])])]),e("div",Ne,[e("div",Te,[e("form",null,[e("div",Ie,[s.value.customer_id?c("",!0):(r(),a("div",$e,[e("label",je,[u("Buscar Clientes "),n.value.customer_id?(r(),a("span",Ee,"*")):c("",!0)]),e("div",Fe,[Re,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.customer_id}]),id:"searchCustomer","onUpdate:modelValue":o[8]||(o[8]=t=>M.value=t),autocomplete:"off",onInput:F},null,34),[[f,M.value]])]),M.value.length>0?(r(),a("div",Le,[e("ul",null,[(r(!0),a(D,null,B(U.value.slice(0,5),t=>(r(),a("li",{key:t.id,class:"text-gray-700 border-b border-gray-300 p-2 flex items-center justify-between"},[e("span",Oe,y(t.NombreRazonSocial),1),e("button",{onClick:i=>R(t),class:"ml-2 bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"},"Selecionar",8,Ge)]))),128))])])):c("",!0)])),s.value.customer_id?(r(),a("div",qe,[e("label",Ze,[u("Cliente "),n.value.customer_id?(r(),a("span",Qe,"*")):c("",!0)]),e("div",Je,[Ke,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.customer_id}]),id:"customer_id","onUpdate:modelValue":o[9]||(o[9]=t=>A.value.NombreRazonSocial=t),autocomplete:"off"},null,2),[[f,A.value.NombreRazonSocial]])])])):c("",!0),e("div",null,[e("label",We,[u("Código "),n.value.codigo?(r(),a("span",Xe,"*")):c("",!0)]),e("div",Ye,[et,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.codigo}]),id:"codigo","onUpdate:modelValue":o[10]||(o[10]=t=>s.value.codigo=t),autocomplete:"off"},null,2),[[f,s.value.codigo]])])]),e("div",null,[e("label",tt,[u("Fecha "),n.value.fechaEmision?(r(),a("span",ot,"*")):c("",!0)]),e("div",lt,[st,m(e("input",{type:"date",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.fechaEmision}]),id:"fechaEmision","onUpdate:modelValue":o[11]||(o[11]=t=>s.value.fechaEmision=t),autocomplete:"off"},null,2),[[f,s.value.fechaEmision]])])]),e("div",null,[e("label",at,[u("Metodo de Pago "),n.value.metodoPago?(r(),a("span",rt,"*")):c("",!0)]),e("div",nt,[it,m(e("select",{class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.metodoPago}]),id:"metodoPago","onUpdate:modelValue":o[12]||(o[12]=t=>s.value.metodoPago=t)},pt,2),[[N,s.value.metodoPago]])])])]),e("div",bt,[e("div",vt,[e("label",ht,[u("Buscar Productos "),n.value.products?(r(),a("span",gt,"*")):c("",!0)]),e("div",ft,[xt,m(e("input",{type:"text",class:b(["w-full bg-white rounded-r-md pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value.products}]),id:"searchProduct","onUpdate:modelValue":o[13]||(o[13]=t=>k.value=t),autocomplete:"off",onInput:L},null,34),[[f,k.value]])]),k.value.length>0?(r(),a("div",_t,[e("ul",null,[(r(!0),a(D,null,B(S.value.slice(0,5),(t,i)=>(r(),a("li",{key:i,class:"text-gray-700 border-b border-gray-300 p-2 flex items-center justify-between"},[e("span",wt,[u(y(t.descripcion)+" - ",1),e("span",yt,"$ "+y(t.precio),1)]),e("button",{onClick:d=>O(t),class:"ml-2 bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600"},"Agregar",8,Vt)]))),128))])])):c("",!0)])]),e("div",Ct,[e("div",zt,[e("table",kt,[Mt,e("tbody",Ht,[(r(!0),a(D,null,B(s.value.products,(t,i)=>(r(),a("tr",{key:i},[e("td",At,[e("div",Dt," # "+y(z.value[i].product_codigo),1),e("div",Pt,y(z.value[i].product_descripcion),1)]),e("td",Bt,[m(e("input",{type:"text",class:b(["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".cantidad"]}]),style:{"font-size":"0.7rem"},id:"cantidad","onUpdate:modelValue":d=>t.cantidad=d,autocomplete:"off",onInput:d=>C(t)},null,42,St),[[f,t.cantidad]])]),e("td",Ut,[x(w(V),_({type:"text",class:["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".precio_unitario"]}],style:{"font-size":"0.7rem"},id:"precio_unitario",modelValue:t.precio_unitario,"onUpdate:modelValue":d=>t.precio_unitario=d,autocomplete:"off"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2},{onChange:d=>C(t)}),null,16,["class","modelValue","onUpdate:modelValue","onChange"])]),e("td",Nt,[x(w(V),_({type:"text",class:["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".descuento"]}],style:{"font-size":"0.7rem"},id:"descuento",modelValue:t.descuento,"onUpdate:modelValue":d=>t.descuento=d,autocomplete:"off"},{prefix:"% "},{onChange:d=>C(t)}),null,16,["class","modelValue","onUpdate:modelValue","onChange"])]),e("td",Tt,[x(w(V),_({type:"text",class:["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".valor_descuento"]}],style:{"font-size":"0.7rem"},id:"valor_descuento",modelValue:t.valor_descuento,"onUpdate:modelValue":d=>t.valor_descuento=d,autocomplete:"off"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2},{disabled:""}),null,16,["class","modelValue","onUpdate:modelValue"])]),e("td",It,[x(w(V),_({type:"text",class:"bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0",style:{"font-size":"0.7rem"},id:"impuestos",modelValue:t.impuestos,"onUpdate:modelValue":d=>t.impuestos=d,autocomplete:"off"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2},{disabled:""}),null,16,["modelValue","onUpdate:modelValue"])]),e("td",$t,[x(w(V),_({type:"text",class:["bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".subtotal"]}],style:{"font-size":"0.7rem"},id:"subtotal",modelValue:t.subtotal,"onUpdate:modelValue":d=>t.subtotal=d,autocomplete:"off"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2}),null,16,["class","modelValue","onUpdate:modelValue"])]),e("td",jt,[x(w(V),_({type:"text",class:["bg-white rounded w-full h-0 py-3 pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value["products."+i+".precio_total"]}],style:{"font-size":"0.7rem"},id:"precio_total",modelValue:t.precio_total,"onUpdate:modelValue":d=>t.precio_total=d,autocomplete:"off"},{prefix:"$ ",decimal:".",separator:",",minimumFractionDigits:2}),null,16,["class","modelValue","onUpdate:modelValue"])]),e("td",Et,[e("div",Ft,[e("a",{onClick:d=>G(i),class:"text-red-500 cursor-pointer hover:text-red-700"},Ot,8,Rt)])])]))),128))]),e("tfoot",null,[e("tr",null,[Gt,e("td",qt,[x(w(V),_({type:"text",class:["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value[""]}],style:{"font-size":"0.7rem"},id:"",modelValue:s.value.descuento_global,"onUpdate:modelValue":o[14]||(o[14]=t=>s.value.descuento_global=t),autocomplete:"off"},{prefix:"% "},{onChange:o[15]||(o[15]=t=>P())}),null,16,["class","modelValue"])]),e("td",Zt,[x(w(V),_({type:"text",class:["bg-white w-full h-0 py-3 rounded pl-2 text-base font-regular outline-0",{"border-red-500 border-2":n.value[""]}],style:{"font-size":"0.7rem"},id:"",modelValue:s.value.valor_descuentoGlobal,"onUpdate:modelValue":o[16]||(o[16]=t=>s.value.valor_descuentoGlobal=t),autocomplete:"off"},{prefix:"$ ",minimumFractionDigits:2}),null,16,["class","modelValue"])]),e("td",Qt,y(Intl.NumberFormat("es-CO",{style:"currency",currency:"COP"}).format(s.value.impuestos)),1),e("td",Jt,y(Intl.NumberFormat("es-CO",{style:"currency",currency:"COP"}).format(s.value.subTotal)),1),e("td",Kt,y(Intl.NumberFormat("es-CO",{style:"currency",currency:"COP"}).format(s.value.total)),1),Wt])])])])])])])])],64)}}};export{lo as default};
