(window.webpackJsonp_wp_post_selector=window.webpackJsonp_wp_post_selector||[]).push([[1],{15:function(e,t,s){}}]),function(e){function t(t){for(var n,a,o=t[0],c=t[1],l=t[2],p=0,d=[];p<o.length;p++)a=o[p],Object.prototype.hasOwnProperty.call(r,a)&&r[a]&&d.push(r[a][0]),r[a]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);for(u&&u(t);d.length;)d.shift()();return i.push.apply(i,l||[]),s()}function s(){for(var e,t=0;t<i.length;t++){for(var s=i[t],n=!0,o=1;o<s.length;o++){var c=s[o];0!==r[c]&&(n=!1)}n&&(i.splice(t--,1),e=a(a.s=s[0]))}return e}var n={},r={0:0},i=[];function a(t){if(n[t])return n[t].exports;var s=n[t]={i:t,l:!1,exports:{}};return e[t].call(s.exports,s,s.exports,a),s.l=!0,s.exports}a.m=e,a.c=n,a.d=function(e,t,s){a.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:s})},a.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},a.t=function(e,t){if(1&t&&(e=a(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var s=Object.create(null);if(a.r(s),Object.defineProperty(s,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)a.d(s,n,function(t){return e[t]}.bind(null,n));return s},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,"a",t),t},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},a.p="";var o=window.webpackJsonp_wp_post_selector=window.webpackJsonp_wp_post_selector||[],c=o.push.bind(o);o.push=t,o=o.slice();for(var l=0;l<o.length;l++)t(o[l]);var u=c;i.push([34,1]),s()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.components},function(e,t,s){"use strict";var n=s(7),r=Object.prototype.toString;function i(e){return"[object Array]"===r.call(e)}function a(e){return void 0===e}function o(e){return null!==e&&"object"==typeof e}function c(e){if("[object Object]"!==r.call(e))return!1;var t=Object.getPrototypeOf(e);return null===t||t===Object.prototype}function l(e){return"[object Function]"===r.call(e)}function u(e,t){if(null!=e)if("object"!=typeof e&&(e=[e]),i(e))for(var s=0,n=e.length;s<n;s++)t.call(null,e[s],s,e);else for(var r in e)Object.prototype.hasOwnProperty.call(e,r)&&t.call(null,e[r],r,e)}e.exports={isArray:i,isArrayBuffer:function(e){return"[object ArrayBuffer]"===r.call(e)},isBuffer:function(e){return null!==e&&!a(e)&&null!==e.constructor&&!a(e.constructor)&&"function"==typeof e.constructor.isBuffer&&e.constructor.isBuffer(e)},isFormData:function(e){return"undefined"!=typeof FormData&&e instanceof FormData},isArrayBufferView:function(e){return"undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(e):e&&e.buffer&&e.buffer instanceof ArrayBuffer},isString:function(e){return"string"==typeof e},isNumber:function(e){return"number"==typeof e},isObject:o,isPlainObject:c,isUndefined:a,isDate:function(e){return"[object Date]"===r.call(e)},isFile:function(e){return"[object File]"===r.call(e)},isBlob:function(e){return"[object Blob]"===r.call(e)},isFunction:l,isStream:function(e){return o(e)&&l(e.pipe)},isURLSearchParams:function(e){return"undefined"!=typeof URLSearchParams&&e instanceof URLSearchParams},isStandardBrowserEnv:function(){return("undefined"==typeof navigator||"ReactNative"!==navigator.product&&"NativeScript"!==navigator.product&&"NS"!==navigator.product)&&"undefined"!=typeof window&&"undefined"!=typeof document},forEach:u,merge:function e(){var t={};function s(s,n){c(t[n])&&c(s)?t[n]=e(t[n],s):c(s)?t[n]=e({},s):i(s)?t[n]=s.slice():t[n]=s}for(var n=0,r=arguments.length;n<r;n++)u(arguments[n],s);return t},extend:function(e,t,s){return u(t,(function(t,r){e[r]=s&&"function"==typeof t?n(t,s):t})),e},trim:function(e){return e.replace(/^\s*/,"").replace(/\s*$/,"")},stripBOM:function(e){return 65279===e.charCodeAt(0)&&(e=e.slice(1)),e}}},function(e,t){e.exports=window.wp.blockEditor},function(e,t,s){e.exports=s(16)},function(e,t){e.exports=window.wp.i18n},function(e,t){function s(){return e.exports=s=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var s=arguments[t];for(var n in s)Object.prototype.hasOwnProperty.call(s,n)&&(e[n]=s[n])}return e},e.exports.default=e.exports,e.exports.__esModule=!0,s.apply(this,arguments)}e.exports=s,e.exports.default=e.exports,e.exports.__esModule=!0},function(e,t,s){"use strict";e.exports=function(e,t){return function(){for(var s=new Array(arguments.length),n=0;n<s.length;n++)s[n]=arguments[n];return e.apply(t,s)}}},function(e,t,s){"use strict";var n=s(2);function r(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}e.exports=function(e,t,s){if(!t)return e;var i;if(s)i=s(t);else if(n.isURLSearchParams(t))i=t.toString();else{var a=[];n.forEach(t,(function(e,t){null!=e&&(n.isArray(e)?t+="[]":e=[e],n.forEach(e,(function(e){n.isDate(e)?e=e.toISOString():n.isObject(e)&&(e=JSON.stringify(e)),a.push(r(t)+"="+r(e))})))})),i=a.join("&")}if(i){var o=e.indexOf("#");-1!==o&&(e=e.slice(0,o)),e+=(-1===e.indexOf("?")?"?":"&")+i}return e}},function(e,t,s){"use strict";e.exports=function(e){return!(!e||!e.__CANCEL__)}},function(e,t,s){"use strict";(function(t){var n=s(2),r=s(22),i={"Content-Type":"application/x-www-form-urlencoded"};function a(e,t){!n.isUndefined(e)&&n.isUndefined(e["Content-Type"])&&(e["Content-Type"]=t)}var o,c={adapter:(("undefined"!=typeof XMLHttpRequest||void 0!==t&&"[object process]"===Object.prototype.toString.call(t))&&(o=s(11)),o),transformRequest:[function(e,t){return r(t,"Accept"),r(t,"Content-Type"),n.isFormData(e)||n.isArrayBuffer(e)||n.isBuffer(e)||n.isStream(e)||n.isFile(e)||n.isBlob(e)?e:n.isArrayBufferView(e)?e.buffer:n.isURLSearchParams(e)?(a(t,"application/x-www-form-urlencoded;charset=utf-8"),e.toString()):n.isObject(e)?(a(t,"application/json;charset=utf-8"),JSON.stringify(e)):e}],transformResponse:[function(e){if("string"==typeof e)try{e=JSON.parse(e)}catch(e){}return e}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,validateStatus:function(e){return e>=200&&e<300},headers:{common:{Accept:"application/json, text/plain, */*"}}};n.forEach(["delete","get","head"],(function(e){c.headers[e]={}})),n.forEach(["post","put","patch"],(function(e){c.headers[e]=n.merge(i)})),e.exports=c}).call(this,s(21))},function(e,t,s){"use strict";var n=s(2),r=s(23),i=s(25),a=s(8),o=s(26),c=s(29),l=s(30),u=s(12);e.exports=function(e){return new Promise((function(t,s){var p=e.data,d=e.headers;n.isFormData(p)&&delete d["Content-Type"];var h=new XMLHttpRequest;if(e.auth){var f=e.auth.username||"",m=e.auth.password?unescape(encodeURIComponent(e.auth.password)):"";d.Authorization="Basic "+btoa(f+":"+m)}var g=o(e.baseURL,e.url);if(h.open(e.method.toUpperCase(),a(g,e.params,e.paramsSerializer),!0),h.timeout=e.timeout,h.onreadystatechange=function(){if(h&&4===h.readyState&&(0!==h.status||h.responseURL&&0===h.responseURL.indexOf("file:"))){var n="getAllResponseHeaders"in h?c(h.getAllResponseHeaders()):null,i={data:e.responseType&&"text"!==e.responseType?h.response:h.responseText,status:h.status,statusText:h.statusText,headers:n,config:e,request:h};r(t,s,i),h=null}},h.onabort=function(){h&&(s(u("Request aborted",e,"ECONNABORTED",h)),h=null)},h.onerror=function(){s(u("Network Error",e,null,h)),h=null},h.ontimeout=function(){var t="timeout of "+e.timeout+"ms exceeded";e.timeoutErrorMessage&&(t=e.timeoutErrorMessage),s(u(t,e,"ECONNABORTED",h)),h=null},n.isStandardBrowserEnv()){var b=(e.withCredentials||l(g))&&e.xsrfCookieName?i.read(e.xsrfCookieName):void 0;b&&(d[e.xsrfHeaderName]=b)}if("setRequestHeader"in h&&n.forEach(d,(function(e,t){void 0===p&&"content-type"===t.toLowerCase()?delete d[t]:h.setRequestHeader(t,e)})),n.isUndefined(e.withCredentials)||(h.withCredentials=!!e.withCredentials),e.responseType)try{h.responseType=e.responseType}catch(t){if("json"!==e.responseType)throw t}"function"==typeof e.onDownloadProgress&&h.addEventListener("progress",e.onDownloadProgress),"function"==typeof e.onUploadProgress&&h.upload&&h.upload.addEventListener("progress",e.onUploadProgress),e.cancelToken&&e.cancelToken.promise.then((function(e){h&&(h.abort(),s(e),h=null)})),p||(p=null),h.send(p)}))}},function(e,t,s){"use strict";var n=s(24);e.exports=function(e,t,s,r,i){var a=new Error(e);return n(a,t,s,r,i)}},function(e,t,s){"use strict";var n=s(2);e.exports=function(e,t){t=t||{};var s={},r=["url","method","data"],i=["headers","auth","proxy","params"],a=["baseURL","transformRequest","transformResponse","paramsSerializer","timeout","timeoutMessage","withCredentials","adapter","responseType","xsrfCookieName","xsrfHeaderName","onUploadProgress","onDownloadProgress","decompress","maxContentLength","maxBodyLength","maxRedirects","transport","httpAgent","httpsAgent","cancelToken","socketPath","responseEncoding"],o=["validateStatus"];function c(e,t){return n.isPlainObject(e)&&n.isPlainObject(t)?n.merge(e,t):n.isPlainObject(t)?n.merge({},t):n.isArray(t)?t.slice():t}function l(r){n.isUndefined(t[r])?n.isUndefined(e[r])||(s[r]=c(void 0,e[r])):s[r]=c(e[r],t[r])}n.forEach(r,(function(e){n.isUndefined(t[e])||(s[e]=c(void 0,t[e]))})),n.forEach(i,l),n.forEach(a,(function(r){n.isUndefined(t[r])?n.isUndefined(e[r])||(s[r]=c(void 0,e[r])):s[r]=c(void 0,t[r])})),n.forEach(o,(function(n){n in t?s[n]=c(e[n],t[n]):n in e&&(s[n]=c(void 0,e[n]))}));var u=r.concat(i).concat(a).concat(o),p=Object.keys(e).concat(Object.keys(t)).filter((function(e){return-1===u.indexOf(e)}));return n.forEach(p,l),s}},function(e,t,s){"use strict";function n(e){this.message=e}n.prototype.toString=function(){return"Cancel"+(this.message?": "+this.message:"")},n.prototype.__CANCEL__=!0,e.exports=n},,function(e,t,s){"use strict";var n=s(2),r=s(7),i=s(17),a=s(13);function o(e){var t=new i(e),s=r(i.prototype.request,t);return n.extend(s,i.prototype,t),n.extend(s,t),s}var c=o(s(10));c.Axios=i,c.create=function(e){return o(a(c.defaults,e))},c.Cancel=s(14),c.CancelToken=s(31),c.isCancel=s(9),c.all=function(e){return Promise.all(e)},c.spread=s(32),c.isAxiosError=s(33),e.exports=c,e.exports.default=c},function(e,t,s){"use strict";var n=s(2),r=s(8),i=s(18),a=s(19),o=s(13);function c(e){this.defaults=e,this.interceptors={request:new i,response:new i}}c.prototype.request=function(e){"string"==typeof e?(e=arguments[1]||{}).url=arguments[0]:e=e||{},(e=o(this.defaults,e)).method?e.method=e.method.toLowerCase():this.defaults.method?e.method=this.defaults.method.toLowerCase():e.method="get";var t=[a,void 0],s=Promise.resolve(e);for(this.interceptors.request.forEach((function(e){t.unshift(e.fulfilled,e.rejected)})),this.interceptors.response.forEach((function(e){t.push(e.fulfilled,e.rejected)}));t.length;)s=s.then(t.shift(),t.shift());return s},c.prototype.getUri=function(e){return e=o(this.defaults,e),r(e.url,e.params,e.paramsSerializer).replace(/^\?/,"")},n.forEach(["delete","get","head","options"],(function(e){c.prototype[e]=function(t,s){return this.request(o(s||{},{method:e,url:t,data:(s||{}).data}))}})),n.forEach(["post","put","patch"],(function(e){c.prototype[e]=function(t,s,n){return this.request(o(n||{},{method:e,url:t,data:s}))}})),e.exports=c},function(e,t,s){"use strict";var n=s(2);function r(){this.handlers=[]}r.prototype.use=function(e,t){return this.handlers.push({fulfilled:e,rejected:t}),this.handlers.length-1},r.prototype.eject=function(e){this.handlers[e]&&(this.handlers[e]=null)},r.prototype.forEach=function(e){n.forEach(this.handlers,(function(t){null!==t&&e(t)}))},e.exports=r},function(e,t,s){"use strict";var n=s(2),r=s(20),i=s(9),a=s(10);function o(e){e.cancelToken&&e.cancelToken.throwIfRequested()}e.exports=function(e){return o(e),e.headers=e.headers||{},e.data=r(e.data,e.headers,e.transformRequest),e.headers=n.merge(e.headers.common||{},e.headers[e.method]||{},e.headers),n.forEach(["delete","get","head","post","put","patch","common"],(function(t){delete e.headers[t]})),(e.adapter||a.adapter)(e).then((function(t){return o(e),t.data=r(t.data,t.headers,e.transformResponse),t}),(function(t){return i(t)||(o(e),t&&t.response&&(t.response.data=r(t.response.data,t.response.headers,e.transformResponse))),Promise.reject(t)}))}},function(e,t,s){"use strict";var n=s(2);e.exports=function(e,t,s){return n.forEach(s,(function(s){e=s(e,t)})),e}},function(e,t){var s,n,r=e.exports={};function i(){throw new Error("setTimeout has not been defined")}function a(){throw new Error("clearTimeout has not been defined")}function o(e){if(s===setTimeout)return setTimeout(e,0);if((s===i||!s)&&setTimeout)return s=setTimeout,setTimeout(e,0);try{return s(e,0)}catch(t){try{return s.call(null,e,0)}catch(t){return s.call(this,e,0)}}}!function(){try{s="function"==typeof setTimeout?setTimeout:i}catch(e){s=i}try{n="function"==typeof clearTimeout?clearTimeout:a}catch(e){n=a}}();var c,l=[],u=!1,p=-1;function d(){u&&c&&(u=!1,c.length?l=c.concat(l):p=-1,l.length&&h())}function h(){if(!u){var e=o(d);u=!0;for(var t=l.length;t;){for(c=l,l=[];++p<t;)c&&c[p].run();p=-1,t=l.length}c=null,u=!1,function(e){if(n===clearTimeout)return clearTimeout(e);if((n===a||!n)&&clearTimeout)return n=clearTimeout,clearTimeout(e);try{n(e)}catch(t){try{return n.call(null,e)}catch(t){return n.call(this,e)}}}(e)}}function f(e,t){this.fun=e,this.array=t}function m(){}r.nextTick=function(e){var t=new Array(arguments.length-1);if(arguments.length>1)for(var s=1;s<arguments.length;s++)t[s-1]=arguments[s];l.push(new f(e,t)),1!==l.length||u||o(h)},f.prototype.run=function(){this.fun.apply(null,this.array)},r.title="browser",r.browser=!0,r.env={},r.argv=[],r.version="",r.versions={},r.on=m,r.addListener=m,r.once=m,r.off=m,r.removeListener=m,r.removeAllListeners=m,r.emit=m,r.prependListener=m,r.prependOnceListener=m,r.listeners=function(e){return[]},r.binding=function(e){throw new Error("process.binding is not supported")},r.cwd=function(){return"/"},r.chdir=function(e){throw new Error("process.chdir is not supported")},r.umask=function(){return 0}},function(e,t,s){"use strict";var n=s(2);e.exports=function(e,t){n.forEach(e,(function(s,n){n!==t&&n.toUpperCase()===t.toUpperCase()&&(e[t]=s,delete e[n])}))}},function(e,t,s){"use strict";var n=s(12);e.exports=function(e,t,s){var r=s.config.validateStatus;s.status&&r&&!r(s.status)?t(n("Request failed with status code "+s.status,s.config,null,s.request,s)):e(s)}},function(e,t,s){"use strict";e.exports=function(e,t,s,n,r){return e.config=t,s&&(e.code=s),e.request=n,e.response=r,e.isAxiosError=!0,e.toJSON=function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:this.config,code:this.code}},e}},function(e,t,s){"use strict";var n=s(2);e.exports=n.isStandardBrowserEnv()?{write:function(e,t,s,r,i,a){var o=[];o.push(e+"="+encodeURIComponent(t)),n.isNumber(s)&&o.push("expires="+new Date(s).toGMTString()),n.isString(r)&&o.push("path="+r),n.isString(i)&&o.push("domain="+i),!0===a&&o.push("secure"),document.cookie=o.join("; ")},read:function(e){var t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove:function(e){this.write(e,"",Date.now()-864e5)}}:{write:function(){},read:function(){return null},remove:function(){}}},function(e,t,s){"use strict";var n=s(27),r=s(28);e.exports=function(e,t){return e&&!n(t)?r(e,t):t}},function(e,t,s){"use strict";e.exports=function(e){return/^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(e)}},function(e,t,s){"use strict";e.exports=function(e,t){return t?e.replace(/\/+$/,"")+"/"+t.replace(/^\/+/,""):e}},function(e,t,s){"use strict";var n=s(2),r=["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"];e.exports=function(e){var t,s,i,a={};return e?(n.forEach(e.split("\n"),(function(e){if(i=e.indexOf(":"),t=n.trim(e.substr(0,i)).toLowerCase(),s=n.trim(e.substr(i+1)),t){if(a[t]&&r.indexOf(t)>=0)return;a[t]="set-cookie"===t?(a[t]?a[t]:[]).concat([s]):a[t]?a[t]+", "+s:s}})),a):a}},function(e,t,s){"use strict";var n=s(2);e.exports=n.isStandardBrowserEnv()?function(){var e,t=/(msie|trident)/i.test(navigator.userAgent),s=document.createElement("a");function r(e){var n=e;return t&&(s.setAttribute("href",n),n=s.href),s.setAttribute("href",n),{href:s.href,protocol:s.protocol?s.protocol.replace(/:$/,""):"",host:s.host,search:s.search?s.search.replace(/^\?/,""):"",hash:s.hash?s.hash.replace(/^#/,""):"",hostname:s.hostname,port:s.port,pathname:"/"===s.pathname.charAt(0)?s.pathname:"/"+s.pathname}}return e=r(window.location.href),function(t){var s=n.isString(t)?r(t):t;return s.protocol===e.protocol&&s.host===e.host}}():function(){return!0}},function(e,t,s){"use strict";var n=s(14);function r(e){if("function"!=typeof e)throw new TypeError("executor must be a function.");var t;this.promise=new Promise((function(e){t=e}));var s=this;e((function(e){s.reason||(s.reason=new n(e),t(s.reason))}))}r.prototype.throwIfRequested=function(){if(this.reason)throw this.reason},r.source=function(){var e;return{token:new r((function(t){e=t})),cancel:e}},e.exports=r},function(e,t,s){"use strict";e.exports=function(e){return function(t){return e.apply(null,t)}}},function(e,t,s){"use strict";e.exports=function(e){return"object"==typeof e&&!0===e.isAxiosError}},function(e,t,s){"use strict";s.r(t);var n=s(0),r=(s(15),s(4)),i=s.n(r),a=s(3),o=s(6),c=s.n(o);const l=({title:{rendered:e}={},clickHandler:t,id:s,featured_image:r=!1,icon:i})=>Object(n.createElement)("article",{className:"post"},Object(n.createElement)("figure",{className:"post-figure",style:{backgroundImage:`url(${r})`}}),Object(n.createElement)("div",{className:"post-body"},Object(n.createElement)("h3",{className:"post-title"},e)),Object(n.createElement)("button",{className:"btn",onClick:()=>t(s)},i)),u=e=>{const{filtered:t=!1,loading:s=!1,posts:r=[],action:i=(()=>{}),icon:a=null}=e;return r.map(e=>Object(n.createElement)(l,c()({key:e.id},e,{clickHandler:i,icon:a}))),s?Object(n.createElement)("p",null,"Loading posts..."):t&&r.length<1||t&&r.length<1?Object(n.createElement)("div",{className:"post-list"},Object(n.createElement)("p",null,"Your query yielded no results, please try again.")):!r||r.length<1?Object(n.createElement)("p",null,"keine Beiträge ausgewählt ..."):Object(n.createElement)("div",{className:"post-list block-posts"},Object(n.createElement)("div",{className:"post-list-wrapper"},r.map(e=>Object(n.createElement)(l,c()({key:e.id},e,{clickHandler:i,icon:a})))),Object(n.createElement)("div",{className:"btn-wrapper-center"},e.canPaginate?Object(n.createElement)("button",{className:"btn btn-more",onClick:e.doPagination,disabled:e.paging},e.paging?"Loading...":"mehr laden"):null))},p=e=>((e,t)=>{let s=[];return e.filter(e=>-1===s.indexOf(e.id)&&s.push(e.id))})(e),d=(e,t)=>{let s=null;return function(){const n=this,r=arguments,i=()=>{e.apply(n,r)};clearTimeout(s),s=setTimeout(i,t)}},{Component:h}=wp.element;class f extends h{constructor(e){super(...arguments),this.props=e,this.state={posts:[],loading:!1,type:"post",types:[],filter:"",filterLoading:!1,filterPosts:[],pages:{},pagesTotal:{},paging:!1,initialLoading:!1,showPosts:!1},this.addPost=this.addPost.bind(this),this.removePost=this.removePost.bind(this),this.handlePostTypeChange=this.handlePostTypeChange.bind(this),this.handleInputFilterChange=this.handleInputFilterChange.bind(this),this.doPostFilter=d(this.doPostFilter.bind(this),300),this.doPagination=this.doPagination.bind(this)}toggle(){this.setState({showPosts:!this.state.showPosts})}componentDidMount(){this.setState({loading:!0,initialLoading:!0}),i.a.get("/wp-json/wp/v2/types").then(({data:e={}}={})=>{delete e.attachment,delete e.wp_block,delete e.wp_template,delete e.starter_footer,delete e.starter_header,this.setState({types:e},()=>{this.retrieveSelectedPosts().then(()=>{this.setState({initialLoading:!1}),this.getPosts().then(()=>{this.setState({loading:!1})})})})})}retrieveSelectedPosts(){const e=this.props.selectedPosts,{types:t}=this.state;return!e.length>0?new Promise(e=>e()):Promise.all(Object.keys(t).map(e=>this.getPosts({include:this.props.selectedPosts.join(","),per_page:100,type:e})))}getPosts(e={}){const t=!this.state.filter&&this.state.type,s={per_page:10,type:this.state.type,search:this.state.filter,page:this.state.pages[t]||1,...e};return s.restBase=this.state.types[s.type].rest_base,(({restBase:e=!1,...t})=>{const s=Object.keys(t).map(e=>`${e}=${t[e]}`).join("&");return i.a.get(`/wp-json/wp/v2/${e}?${s}&_embed`)})(s).then(e=>{const{data:t}=e,s=t.map(e=>!e.featured_media||e.featured_media<1?{...e,featured_image:!1}:{...e,featured_image:e._embedded["wp:featuredmedia"][0].source_url||!1});return{...e,data:s}}).then(e=>s.search?(this.setState({filterPosts:s.page>1?p([...this.state.filterPosts,...e.data]):e.data,pages:{...this.state.pages,filter:s.page},pagesTotal:{...this.state.pagesTotal,filter:e.headers["x-wp-totalpages"]}}),e):(this.setState({posts:p([...this.state.posts,...e.data]),pages:{...this.state.pages,[t]:s.page},pagesTotal:{...this.state.pagesTotal,[t]:e.headers["x-wp-totalpages"]}}),e))}addPost(e){if(this.state.filter){const t=this.state.filterPosts.filter(t=>t.id===e),s=p([...this.state.posts,...t]);this.setState({posts:s})}this.props.updateSelectedPosts([...this.props.selectedPosts,e])}removePost(e){this.props.updateSelectedPosts([...this.props.selectedPosts].filter(t=>t!==e))}getSelectedPosts(){const{selectedPosts:e}=this.props;return this.state.posts.filter(({id:t})=>-1!==e.indexOf(t)).sort((e,t)=>{const s=this.props.selectedPosts.indexOf(e.id),n=this.props.selectedPosts.indexOf(t.id);return s>n?1:s<n?-1:0})}handlePostTypeChange({target:{value:e=""}={}}={}){this.setState({type:e,loading:!0},()=>{this.getPosts().then(()=>this.setState({loading:!1}))})}handleInputFilterChange({target:{value:e=""}={}}={}){this.setState({filter:e},()=>{if(!e)return this.setState({filteredPosts:[],filtering:!1});this.doPostFilter()})}doPostFilter(){const{filter:e=""}=this.state;e&&(this.setState({filtering:!0,filterLoading:!0}),this.getPosts().then(()=>{this.setState({filterLoading:!1})}))}doPagination(){this.setState({paging:!0});const e=this.state.filter?"filter":this.state.type,t=parseInt(this.state.pages[e],10)+1||2;this.getPosts({page:t}).then(()=>this.setState({paging:!1}))}render(){const e=this.state.filtering,t=e&&!this.state.filterLoading?this.state.filterPosts:this.state.posts.filter(e=>e.type===this.state.type),s=this.state.filter?"filter":this.state.type,r=(this.state.pages[s]||1)<this.state.pagesTotal[s],i=Object(n.createElement)(a.BlockIcon,{icon:"plus"}),o=Object(n.createElement)(a.BlockIcon,{icon:"minus"});return Object(n.createElement)("div",{className:"post-selector"},Object(n.createElement)("div",{className:"btn-wrapper"},Object(n.createElement)("button",{className:"btn btn-more",onClick:this.toggle.bind(this)},this.state.showPosts?"Auswahl schließen":"Beiträge hinzufügen")),Object(n.createElement)("div",{className:this.state.showPosts?"section-wp-post":"hide"},Object(n.createElement)(({color:e})=>Object(n.createElement)("hr",{className:"hr-trenner"}),{color:"black"}),Object(n.createElement)("div",{className:"post-selectorHeader"},Object(n.createElement)("div",{className:"post-select"},Object(n.createElement)("label",{className:"form-label",htmlFor:"options"},"Post Type: "),Object(n.createElement)("select",{className:"form-select",name:"options",id:"options",onChange:this.handlePostTypeChange},this.state.types.length<1?Object(n.createElement)("option",{value:""},"loading"):Object.keys(this.state.types).map(e=>Object(n.createElement)("option",{key:e,value:e},this.state.types[e].name)))),Object(n.createElement)("div",{className:"searchbox"},Object(n.createElement)("label",{className:"form-label"}," Beitrag suchen"),Object(n.createElement)("label",{className:"lbl-search",htmlFor:"searchinput"},Object(n.createElement)("div",{className:"search-wrapper"},Object(n.createElement)(a.BlockIcon,{icon:"search"}),Object(n.createElement)("input",{id:"searchinput",type:"search",value:this.state.filter,onChange:this.handleInputFilterChange}))))),Object(n.createElement)("div",{className:"all-posts"},Object(n.createElement)("h3",{className:"header-selected-post"},"Beiträge hinzufügen"),Object(n.createElement)(u,{posts:t,loading:this.state.initialLoading||this.state.loading||this.state.filterLoading,filtered:e,action:this.addPost,paging:this.state.paging,canPaginate:r,doPagination:this.doPagination,icon:i}))),Object(n.createElement)("div",{className:"selected-post"},Object(n.createElement)("h3",{className:"header-selected-post"},"ausgewählte Beiträge"),Object(n.createElement)(u,{posts:this.getSelectedPosts(),loading:this.state.loading,action:this.removePost,icon:o})))}}const{Component:m}=wp.element;class g extends m{constructor(e){super(...arguments),this.props=e,this.state={categories:[]},this.catSelectChange=this.catSelectChange.bind(this)}componentDidMount(){i.a.get("/wp-json/wp/v2/categories").then(e=>{this.setState({categories:e})})}catSelectChange(e){this.props.updateSelectedCategory(this.props.selectedCat=e)}render(){return Object(n.createElement)("div",{className:"settings-form-flex-column"},Object(n.createElement)("label",{className:"form-label",htmlFor:"catSelect"},"Kategorie auswählen: "),Object(n.createElement)("select",{"data-select":this.props.selectedCat,className:"form-select",name:"options",id:"catSelect",onChange:e=>this.catSelectChange(e.target.value)},Object(n.createElement)("option",{value:"0"}," auswählen ..."),this.state.categories.data?this.state.categories.data.map((e,t)=>Object(n.createElement)("option",{key:t,value:e.id,selected:e.id==this.props.selectedCat},e.name)):Object(n.createElement)("option",{value:""},"loading")))}}const{Component:b}=wp.element;class v extends b{constructor(e){super(...arguments),this.props=e,this.state={selectSlider:[],selectGalerie:[],radioCheck:""},this.sliderSelectChange=this.sliderSelectChange.bind(this),this.galerieSelectChange=this.galerieSelectChange.bind(this)}componentDidMount(){let e=document.getElementsByName("type_check"),t="";for(let s=0,n=e.length;s<n;s++)if(e[s].checked){t=e[s].value;break}i.a.get(WPPSRestObj.url+"get_post_slider?input="+t,{headers:{"content-type":"application/json","X-WP-Nonce":WPPSRestObj.nonce}}).then(({data:e={}}={})=>{this.setState({selectSlider:e.slider,selectGalerie:e.galerie,radioCheck:e.radio_check})})}sliderSelectChange(e){this.props.updateSelectedSlider(this.props.selectedSlider=e)}galerieSelectChange(e){this.props.updateSelectedGalerie(this.props.selectedGalerie=e)}render(){let e,t;return e=1!=this.state.radioCheck,t=2!=this.state.radioCheck,3==this.state.radioCheck&&(e=!0,t=!0),Object(n.createElement)("div",null,Object(n.createElement)("div",{className:"settings-form-flex-column"},Object(n.createElement)("label",{className:"form-label",htmlFor:"sliderSelect"},Object(n.createElement)("b",{className:"b-fett"},"Slider")," Vorlage auswählen: "),Object(n.createElement)("select",{className:"form-select",name:"options",id:"sliderSelect",onChange:e=>this.sliderSelectChange(e.target.value),disabled:e},Object(n.createElement)("option",{value:""}," auswählen ..."),this.state.selectSlider?this.state.selectSlider.map((e,t)=>Object(n.createElement)("option",{key:t,value:e.id,selected:e.id==this.props.selectedSlider},e.name)):Object(n.createElement)("option",{value:""},"loading"))),Object(n.createElement)("div",{className:"settings-form-flex-column"},Object(n.createElement)("label",{className:"form-label",htmlFor:"galerieSelect"},Object(n.createElement)("b",{className:"b-fett"},"Grid")," Vorlage auswählen: "),Object(n.createElement)("select",{className:"form-select",name:"options",id:"galerieSelect",onChange:e=>this.galerieSelectChange(e.target.value),disabled:t},Object(n.createElement)("option",{value:""}," auswählen ..."),this.state.selectGalerie?this.state.selectGalerie.map((e,t)=>Object(n.createElement)("option",{key:t,value:e.id,selected:e.id==this.props.selectedGalerie},e.name)):Object(n.createElement)("option",{value:""},"loading"))))}}var y=s(5),O=s(1);const{Component:j}=wp.element,{registerBlockType:E,PlainText:C}=wp.blocks;E("hupa/theme-post-selector",{title:Object(y.__)("Post Selector"),icon:"controls-repeat",category:"media",attributes:{selectedPosts:{type:"array",default:[]},selectedCat:{type:"string"},selectedSlider:{type:"string"},selectedGalerie:{type:"string"},postCheckActive:{type:"bool",default:!1},catCheckActive:{type:"bool",default:!1},linkCheckActive:{type:"bool",default:!1},titleCheckActive:{type:"bool",default:!1},imageCheckActive:{type:"bool",default:!1},postCount:{type:"string"},hoverBGColor:{type:"string",default:""},TextColor:{type:"string",default:""},outputType:{type:"string"},radioOutputPosts:{type:"string"},radioMedienLink:{type:"string"},lightBoxActive:{type:"bool",default:!1}},keywords:[Object(y.__)(" gutenberg post selector BY Jens Wiecker"),Object(y.__)("Gutenberg GRID SLIDER")],edit:class extends j{constructor(e){super(...arguments),this.props=e,this.updateSelectedPosts=this.updateSelectedPosts.bind(this),this.updateSelectedCategory=this.updateSelectedCategory.bind(this),this.updateSelectedSlider=this.updateSelectedSlider.bind(this),this.updateSelectedGalerie=this.updateSelectedGalerie.bind(this),this.updateLinkActiveToggle=this.updateLinkActiveToggle.bind(this),this.updateTitleActiveToggle=this.updateTitleActiveToggle.bind(this),this.updateImageActiveToggle=this.updateImageActiveToggle.bind(this),this.onCountChange=this.onCountChange.bind(this),this.onChangeBGColor=this.onChangeBGColor.bind(this),this.onChangeTextColor=this.onChangeTextColor.bind(this),this.onOutputRadio=this.onOutputRadio.bind(this),this.onOutputPostsRadio=this.onOutputPostsRadio.bind(this),this.updateLightBoxActiveToggle=this.updateLightBoxActiveToggle.bind(this),this.onUpdateRadioMedienLink=this.onUpdateRadioMedienLink.bind(this)}updateSelectedPosts(e){this.props.setAttributes({selectedPosts:e})}updateSelectedCategory(e){this.props.setAttributes({selectedCat:e}),document.querySelector(".components-panel__body.post-select-panel-body")}updateSelectedSlider(e){this.props.setAttributes({selectedSlider:e})}updateSelectedGalerie(e){this.props.setAttributes({selectedGalerie:e})}updateTitleActiveToggle(e){this.props.setAttributes({titleCheckActive:e})}updateImageActiveToggle(e){return"1"==this.props.attributes.outputType||"2"==this.props.attributes.outputType?(this.props.attributes.imageCheckActive=!0,!1):void this.props.setAttributes({imageCheckActive:e})}updateLinkActiveToggle(e){this.props.setAttributes({linkCheckActive:e})}onCountChange(e){e<0&&(e=0),this.props.setAttributes({postCount:e})}onChangeBGColor(e){this.props.setAttributes({hoverBGColor:e})}onChangeTextColor(e){this.props.setAttributes({TextColor:e})}onOutputRadio(e){const t=document.getElementById("galerieSelect"),s=document.getElementById("sliderSelect");1==e&&(s.removeAttribute("disabled"),t.setAttribute("disabled","disabled"),this.props.attributes.imageCheckActive=!0),2==e&&(s.setAttribute("disabled","disabled"),t.removeAttribute("disabled"),this.props.attributes.imageCheckActive=!0),3==e&&(t.setAttribute("disabled","disabled"),s.setAttribute("disabled","disabled")),this.props.setAttributes({outputType:e})}onOutputPostsRadio(e){this.props.setAttributes({radioOutputPosts:e})}onUpdateRadioMedienLink(e){2==e&&(this.props.attributes.lightBoxActive=!1),this.props.setAttributes({radioMedienLink:e})}updateLightBoxActiveToggle(e){e&&(this.props.attributes.radioMedienLink="1"),this.props.setAttributes({lightBoxActive:e})}render(){const e=({color:e})=>Object(n.createElement)("hr",{className:"hr-small-trenner"}),{linkActive:t,attributes:{linkCheckActive:s=!1}={}}=this.props,{titleActive:r,attributes:{titleCheckActive:i=!1}={}}=this.props,{countInput:o,attributes:{postCount:c=""}={}}=this.props,{inputBGColor:l,attributes:{hoverBGColor:u=""}={}}=this.props,{inputTextColor:p,attributes:{TextColor:d=""}={}}=this.props,{radioAusgabePosts:h,attributes:{radioOutputPosts:m="2"}={}}=this.props,{radioCheckAusgabe:b,attributes:{outputType:j=""}={}}=this.props,{radioOutputMedienLink:E,attributes:{radioMedienLink:C="1"}={}}=this.props,{imageActive:w,attributes:{imageCheckActive:S=!0}={}}=this.props,{lightboxCheckActive:x,attributes:{lightBoxActive:P="1"}={}}=this.props;return Object(n.createElement)("div",{className:"wp-block-hupa-theme-post-list"},Object(n.createElement)(a.InspectorControls,null,Object(n.createElement)("div",{id:"hupa-posts-controls"},Object(n.createElement)(O.Panel,null,Object(n.createElement)(O.PanelBody,{className:"hupa-body-sidebar",title:"Ausgabe Settings",initialOpen:!0},Object(n.createElement)(e,null),Object(n.createElement)("div",{className:"sidebar-input-headline"},"Kategorie"),Object(n.createElement)("div",{className:"settings-form-flex-column"},Object(n.createElement)(g,{selectedCat:this.props.attributes.selectedCat,updateSelectedCategory:this.updateSelectedCategory})),Object(n.createElement)(e,null),Object(n.createElement)(O.TextControl,{className:o,label:"Anzahl der Beiträge:",value:c,onChange:this.onCountChange,type:"number"}),Object(n.createElement)("div",{className:"small-help"},"Nur relevant bei Kategorie-Auswahl."),Object(n.createElement)(e,null),Object(n.createElement)("div",{className:"sidebar-input-headline"},"Ausgabe Typ"),Object(n.createElement)("div",{className:"radio-btn-wrapper"},Object(n.createElement)("div",{className:b},Object(n.createElement)(O.RadioControl,{name:"type_check",selected:j,options:[{label:"Slider",value:"1"},{label:"Grid",value:"2"},{label:"News",value:"3"}],onChange:this.onOutputRadio}))),Object(n.createElement)(v,{selectedSlider:this.props.attributes.selectedSlider,updateSelectedSlider:this.updateSelectedSlider,selectedGalerie:this.props.attributes.selectedGalerie,updateSelectedGalerie:this.updateSelectedGalerie}))),Object(n.createElement)(O.Panel,null,Object(n.createElement)(O.PanelBody,{className:"hupa-body-sidebar",title:"Ansicht",initialOpen:!0},Object(n.createElement)(O.ToggleControl,{className:t,label:"Link zum Beitrag anzeigen",checked:s,onChange:this.updateLinkActiveToggle}),Object(n.createElement)(O.ToggleControl,{className:r,label:"Beitragstitel anzeigen",checked:i,onChange:this.updateTitleActiveToggle}),Object(n.createElement)(O.ToggleControl,{className:w,label:"Beitragbild anzeigen",checked:S,onChange:this.updateImageActiveToggle}),Object(n.createElement)(e,null),Object(n.createElement)(O.ToggleControl,{className:x,label:"Lightbox aktiv",checked:P,onChange:this.updateLightBoxActiveToggle}),Object(n.createElement)(e,null),Object(n.createElement)("div",{className:"sidebar-input-headline"},Object(n.createElement)("b",null,"Image")," Link"),Object(n.createElement)("div",{className:"radio-btn-wrapper"},Object(n.createElement)("div",{className:E},Object(n.createElement)(O.RadioControl,{name:"medien_check",selected:C,options:[{label:"Mediendatei",value:"1"},{label:"Anhang-Seite",value:"2"}],onChange:this.onUpdateRadioMedienLink}))))),Object(n.createElement)(O.Panel,null,Object(n.createElement)(O.PanelBody,{className:"hupa-body-sidebar",title:"Farben",initialOpen:!1},Object(n.createElement)("div",{className:"sidebar-input-headline"},"Textfarbe"),Object(n.createElement)("div",{className:p},Object(n.createElement)(a.ColorPaletteControl,{onChange:this.onChangeTextColor,value:d})),Object(n.createElement)("div",{className:"sidebar-input-headline"},Object(y.__)("Hover Hintergrundfarbe","wp-post-selector")),Object(n.createElement)("div",{className:l},Object(n.createElement)(a.ColorPaletteControl,{onChange:this.onChangeBGColor,value:u})))))),Object(n.createElement)("div",{className:"block-panel"},Object(n.createElement)(O.Panel,{header:"Post-Selector"},Object(n.createElement)(O.PanelBody,{title:Object(y.__)("Beiträge auswählen","wp-post-selector"),initialOpen:!1,icon:"format-aside",className:"post-select-panel-body",id:"selectBody"},Object(n.createElement)("div",{id:"post-select",className:"card-body"},Object(n.createElement)(f,{selectedPosts:this.props.attributes.selectedPosts,updateSelectedPosts:this.updateSelectedPosts}))))))}},save:()=>null})}]);