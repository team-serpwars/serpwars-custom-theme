(function(t){function e(e){for(var n,l,r=e[0],o=e[1],u=e[2],p=0,d=[];p<r.length;p++)l=r[p],Object.prototype.hasOwnProperty.call(s,l)&&s[l]&&d.push(s[l][0]),s[l]=0;for(n in o)Object.prototype.hasOwnProperty.call(o,n)&&(t[n]=o[n]);c&&c(e);while(d.length)d.shift()();return i.push.apply(i,u||[]),a()}function a(){for(var t,e=0;e<i.length;e++){for(var a=i[e],n=!0,r=1;r<a.length;r++){var o=a[r];0!==s[o]&&(n=!1)}n&&(i.splice(e--,1),t=l(l.s=a[0]))}return t}var n={},s={app:0},i=[];function l(e){if(n[e])return n[e].exports;var a=n[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,l),a.l=!0,a.exports}l.m=t,l.c=n,l.d=function(t,e,a){l.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},l.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},l.t=function(t,e){if(1&e&&(t=l(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(l.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)l.d(a,n,function(e){return t[e]}.bind(null,n));return a},l.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return l.d(e,"a",e),e},l.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},l.p="/";var r=window["webpackJsonp"]=window["webpackJsonp"]||[],o=r.push.bind(r);r.push=e,r=r.slice();for(var u=0;u<r.length;u++)e(r[u]);var c=o;i.push([0,"chunk-vendors"]),a()})({0:function(t,e,a){t.exports=a("56d7")},"034f":function(t,e,a){"use strict";var n=a("85ec"),s=a.n(n);s.a},"56d7":function(t,e,a){"use strict";a.r(e);a("e260"),a("e6cf"),a("cca6"),a("a79d");var n=a("2b0e"),s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"app"}},[a("b-container",{staticClass:"bv-example-row "},[a("h1",[t._v("Welcome to Serpwars Theme")]),a("h5",[t._v("v 1.0.0")]),a("div",{staticClass:"spacer"}),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 plugins"},[t._v("Plugins")]),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 ml-2 mr-2 templates"},[t._v("Templates")]),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 options"},[t._v("Options")]),a("div",{staticClass:"siema"},[a("div",[a("plugin-states"),a("br"),a("button",{staticClass:"btn btn-success btn-block",on:{click:t.install}},[t._v("Install Plugins")])],1),a("div",[a("elementor-templates")],1),a("div",[a("advance-custom-field-entries")],1)])])],1)},i=[],l=(a("96cf"),a("1da1")),r=a("5530"),o=a("e30e"),u=a.n(o),c=a("2f62"),p=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-list-group",t._l(t.$store.state.loadedData.plugins,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[a("label",{attrs:{for:""}},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.pluginPicked,expression:"pluginPicked"}],attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.pluginPicked)?t._i(t.pluginPicked,e)>-1:t.pluginPicked},on:{change:function(a){var n=t.pluginPicked,s=a.target,i=!!s.checked;if(Array.isArray(n)){var l=e,r=t._i(n,l);s.checked?r<0&&(t.pluginPicked=n.concat([l])):r>-1&&(t.pluginPicked=n.slice(0,r).concat(n.slice(r+1)))}else t.pluginPicked=i}}}),t._v(" "+t._s(e.name))]),""!=e.status?a("span",[a("b-badge",{attrs:{variant:"info",pill:""}},[t._v(t._s(e.status))])],1):a("span",[e.isActive&&e.isInstalled?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Activated")]):t._e(),!e.isActive&&e.isInstalled?a("b-badge",{attrs:{variant:"primary",pill:""}},[t._v("Installed")]):t._e(),e.isActive||e.isInstalled?t._e():a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)])})),1)},d=[],g={name:"PluginStates",data:function(){return{picked:[]}},computed:{pluginPicked:{get:function(){return this.$store.state.pluginPicked},set:function(t){this.$store.commit("setPluginPicked",t)}}}},f=g,m=a("2877"),_=Object(m["a"])(f,p,d,!1,null,null,null),h=_.exports,b=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-row",[a("b-col",{attrs:{cols:"6"}},[a("h4",[t._v("Advance Custom Fields")]),a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.acf,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.title)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1)],1),a("b-col",{attrs:{cols:"6"}},[a("h4",[t._v("Custom Post Types")]),a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.cptui,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.title)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1)],1),a("br"),a("button",{staticClass:"btn btn-success btn-block",on:{click:t.install}},[t._v("Install Options")])],1)},v=[],P={name:"AdvanceCustomFieldEntries",methods:Object(r["a"])({},Object(c["b"])("PluginPost",["loadOptions","getItems","getCPTStatus","install"])),created:function(){var t=this;return Object(l["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.loadOptions();case 2:case"end":return e.stop()}}),e)})))()}},k=P,x=Object(m["a"])(k,b,v,!1,null,null,null),I=x.exports,y=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.elementor_templates,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.name)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1),a("br"),a("button",{staticClass:"btn btn-success btn-block",on:{click:t.importTemplates}},[t._v("Import Templates")])],1)},D=[],w={name:"ElementorTemplates",methods:Object(r["a"])({},Object(c["b"])("PluginPost",["getElementorTemplatesStatus","importTemplates"])),created:function(){var t=this;return Object(l["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.getElementorTemplatesStatus();case 2:case"end":return e.stop()}}),e)})))()}},S=w,j=Object(m["a"])(S,y,D,!1,null,null,null),O=j.exports,T=a("a06b"),C=a.n(T),A={name:"App",data:function(){return{mySiema:{}}},components:{PluginStates:h,AdvanceCustomFieldEntries:I,ElementorTemplates:O},methods:Object(r["a"])({},Object(c["b"])(["loadData","install"])),created:function(){var t=this;return Object(l["a"])(regeneratorRuntime.mark((function e(){var a,n,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.loadData();case 2:t.mySiema=new C.a,a=document.querySelector(".plugins"),n=document.querySelector(".templates"),s=document.querySelector(".options"),a.addEventListener("click",(function(){return t.mySiema.goTo(0)})),n.addEventListener("click",(function(){return t.mySiema.goTo(1)})),s.addEventListener("click",(function(){return t.mySiema.goTo(2)}));case 9:case"end":return e.stop()}}),e)})))()}},E=A,$=(a("034f"),Object(m["a"])(E,s,i,!1,null,null,null)),F=$.exports,q=(a("4160"),a("d81d"),a("b0c0"),a("159b"),a("53ca")),J=a("bc3a"),L=a.n(J),R=a("4328"),B=a.n(R),H=(a("0804"),H||{wpnonce:"4de84d"});console.log(H);var N=N||{ajaxurl:"http://localhost/custom-site/wp-admin/admin-ajax.php"},M=N.ajaxurl||"http://localhost/custom-site/wp-admin/admin-ajax.php";console.log(M),n["default"].use(c["a"]);var X={namespaced:!0,state:{template_imports:{currentIndex:-1,queue:[]},pluginSettings:{elementor_templates:[],acf:[],cptui:[]}},actions:{loadOptions:function(t){var e=t.state,a=t.dispatch;L.a.post(M,B.a.stringify({action:"serpwars_load_options"})).then((function(t){e.pluginSettings=t.data.data,console.log(t.data.data),a("getItems"),a("getCPTStatus"),a("getElementorTemplatesStatus")}))},getItems:function(t){var e=t.state;e.pluginSettings.acf.forEach((function(t,a){L.a.post(M,B.a.stringify({action:"serpwars_check_post_exists",id:t.id})).then((function(t){n["default"].set(e.pluginSettings.acf[a],"found",t.data.success)}))}))},getElementorTemplatesStatus:function(t){var e=t.state;e.pluginSettings.elementor_templates.forEach((function(t,a){0!=t.id?L.a.post(M,B.a.stringify({action:"serpwars_check_post_exists",id:t.id})).then((function(t){n["default"].set(e.pluginSettings.elementor_templates[a],"found",t.data.success)})):n["default"].set(e.pluginSettings.elementor_templates[a],"found",!1)}))},getCPTStatus:function(t){var e=t.state;e.pluginSettings.cptui.forEach((function(t,a){L.a.post(M,B.a.stringify({action:"serpwars_check_cpt_exists",slug:t.slug})).then((function(t){n["default"].set(e.pluginSettings.cptui[a],"found",t.data.success)}))}))},install:function(t){var e=t.state,a=t.dispatch;L.a.post(M,B.a.stringify({action:"serpwars_import_acf_options"})).then((function(t){e.pluginSettings.acf=t.data.data.acf,e.pluginSettings.cptui=t.data.data.cptui,a("getCPTStatus"),t.data.data.acf[0].id||a("install")}))},importTemplates:function(t){var e=t.state,a=t.dispatch;L.a.post(M,B.a.stringify({action:"serpwars_import_templates"})).then((function(t){e.template_imports.queue=t.data.data,e.template_imports.currentIndex=0,a("importTemplate")}))},importTemplate:function(t){var e=t.state,a=t.dispatch;if(e.template_imports.currentIndex<e.template_imports.queue.length){var n=e.template_imports.queue[e.template_imports.currentIndex];console.log(n);var s=n.template;L.a.post(M,B.a.stringify({action:"serpwars_import_elementor_templates",url:s,name:n.name,index:e.template_imports.currentIndex})).then((function(t){e.pluginSettings.elementor_templates[e.template_imports.currentIndex].found=!0,e.template_imports.currentIndex+=1,console.log(t),setTimeout((function(){a("importTemplate")}),5e3)}))}else console.log("All Templates Imported")}}};n["default"].use(c["a"]);var G=G||{ajaxurl:"http://localhost/custom-site/wp-admin/admin-ajax.php"},W=G.ajaxurl||"http://localhost/custom-site/wp-admin/admin-ajax.php";console.log(G);var z=null,K=G.ajaxurl,Q=new c["a"].Store({modules:{PluginPost:X},state:{pluginPicked:[],installerData:{currentItemHash:"",_attemptsBuffer:0,currentIndex:0,_ajaxData:{},_currentItem:void 0},loadedData:{plugins:[],templates:[],pluginSettings:{acf:[{id:331,title:"General Pages"},{id:337,title:"Icon Field"},{id:339,title:"Industry Pages"},{id:385,title:"Services Pages"}]}}},mutations:{setData:function(t,e){t.loadedData.plugins=e;for(var a in t.loadedData.plugins)t.loadedData.plugins[a].isChecked&&t.pluginPicked.push(t.loadedData.plugins[a]);console.log(t.pluginPicked)},setPluginPicked:function(t,e){t.pluginPicked=e,console.log(t.pluginPicked)},setPluginStatus:function(t,e){var a=t.installerData._currentItem.slug;t.loadedData.plugins[a].status=e}},actions:{loadData:function(t){L.a.post(W,B.a.stringify({action:"serpwars_get_plugin_status"})).then((function(e){t.commit("setData",e.data.data)}))},loadThemeAssets:function(t){L.a.post(W,B.a.stringify({action:"serpwars_get_theme_assets"})).then((function(e){t.commit("setData",e.data.data)}))},install:function(t){t.state;u()({text:G.onbefore_text,duration:3e4,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #47a3da, #4284f4)",stopOnFocus:!0}).showToast(),this.dispatch("_installPlugins")},_installPlugins:function(t){var e=t.state;if(e.installerData._currentItem=e.pluginPicked[e.installerData.currentIndex],u()({text:"Installing "+e.installerData._currentItem.name,duration:3e3,close:!0,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #47a3da, #4284f4)",stopOnFocus:!0}).showToast(),e.installerData._currentItem.name){e.installerData_ajaxData={action:"serpwars_setup_plugins",wpnonce:G.wpnonce,slug:e.installerData._currentItem.slug,plugins:e.pluginPicked.map((function(t){return t.slug}))};var a=this;this.commit("setPluginStatus","Installing"),this.dispatch("_globalAJAX",(function(t){a.dispatch("_pluginActions",t.data)}))}},_globalAJAX:function(t,e){var a=t.state;L.a.post(K,B.a.stringify(a.installerData_ajaxData)).then((function(t){return t})).then(e)},_pluginActions:function(t,e){var a=t.state;if("object"===Object(q["a"])(e)&&e.success)if(console.log(this),"undefined"!==typeof e.data.url)if(a.installerData.currentItemHash==e.data.hash)u()({text:"Failed Install  "+a.installerData._currentItem.slug,duration:3e3,close:!0,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #ff0000, #ff0000)",stopOnFocus:!0}).showToast(),a.installerData.currentItemHash=null,this.dispatch("_installPlugins");else{var n=this;K=e.data.url,a.installerData_ajaxData=e.data,a.installerData.currentItemHash=e.data.hash,e.data.url?(console.log(K,a.installerData_ajaxData),L.a.post(e.data.url,B.a.stringify(a.installerData_ajaxData)).then((function(t){return t})).then((function(t){K=W,n.dispatch("_installPlugins")}))):this.dispatch("_globalAJAX",(function(t){K=W,n.dispatch("_installPlugins")}))}else a.installerData._currentItem.isInstalled=!0,a.pluginPicked.forEach((function(t){t.slug==a.installerData._currentItem.slug&&(console.log(t.name),a.installerData._currentItem.isChecked=!1,a.pluginPicked[a.installerData.currentIndex].isChecked=!1,a.installerData._currentItem.isDone=!0,a.installerData._currentItem.isActive=!0,a.installerData._currentItem.status="",a.installerData.currentIndex+=1)})),this.dispatch("_processPlugins");else a.installerData._attemptsBuffer>1?(a.installerData._attemptsBuffer._attemptsBuffer=0,u()({text:"AJAX Error",duration:3e3,close:!0,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #ff0000, #ff0000)",stopOnFocus:!0}).showToast(),this.dispatch("_processPlugins")):(a.installerData.currentItemHash=null,a.installerData._attemptsBuffer+=1,this.dispatch("_installPlugins"))},_processPlugins:function(t){var e=t.state,a=!1,n=e.pluginPicked.map((function(t){if(t.ischecked)return t})),s=this;console.log(e.installerData._currentItem);var i=0;e.pluginPicked.forEach((function(t,n){null==z||a?t.isChecked&&(e.installerData.currentIndex=n,e.pluginPicked[n].status="Installing",e.installerData._currentItem=e.pluginPicked[e.installerData.currentIndex],s.dispatch("_installPlugins"),a=!1):t.slug===e.installerData._currentItem.slug&&(e.pluginPicked[n].status="",a=!0)})),e.pluginPicked.forEach((function(t){t.isDone&&(i+=1)})),i==n.length&&u()({text:"All Items were installed",duration:3e3,close:!0,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #009900, #00aa00)",stopOnFocus:!0}).showToast()}}}),U=a("5f5b"),V=a("b1e0");a("f9e3"),a("2dd8"),a("becf");n["default"].use(U["a"]),n["default"].use(V["a"]),n["default"].config.productionTip=!1;new n["default"]({store:Q,render:function(t){return t(F)}}).$mount("#app")},"85ec":function(t,e,a){}});
//# sourceMappingURL=app.e5f4940f.js.map