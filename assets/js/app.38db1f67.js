(function(t){function e(e){for(var n,i,r=e[0],o=e[1],u=e[2],p=0,d=[];p<r.length;p++)i=r[p],Object.prototype.hasOwnProperty.call(s,i)&&s[i]&&d.push(s[i][0]),s[i]=0;for(n in o)Object.prototype.hasOwnProperty.call(o,n)&&(t[n]=o[n]);c&&c(e);while(d.length)d.shift()();return l.push.apply(l,u||[]),a()}function a(){for(var t,e=0;e<l.length;e++){for(var a=l[e],n=!0,r=1;r<a.length;r++){var o=a[r];0!==s[o]&&(n=!1)}n&&(l.splice(e--,1),t=i(i.s=a[0]))}return t}var n={},s={app:0},l=[];function i(e){if(n[e])return n[e].exports;var a=n[e]={i:e,l:!1,exports:{}};return t[e].call(a.exports,a,a.exports,i),a.l=!0,a.exports}i.m=t,i.c=n,i.d=function(t,e,a){i.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:a})},i.r=function(t){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"===typeof t&&t&&t.__esModule)return t;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var n in t)i.d(a,n,function(e){return t[e]}.bind(null,n));return a},i.n=function(t){var e=t&&t.__esModule?function(){return t["default"]}:function(){return t};return i.d(e,"a",e),e},i.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},i.p="/";var r=window["webpackJsonp"]=window["webpackJsonp"]||[],o=r.push.bind(r);r.push=e,r=r.slice();for(var u=0;u<r.length;u++)e(r[u]);var c=o;l.push([0,"chunk-vendors"]),a()})({0:function(t,e,a){t.exports=a("56d7")},"034f":function(t,e,a){"use strict";var n=a("85ec"),s=a.n(n);s.a},"56d7":function(t,e,a){"use strict";a.r(e);a("e260"),a("e6cf"),a("cca6"),a("a79d");var n=a("2b0e"),s=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{attrs:{id:"app"}},[a("b-container",{staticClass:"bv-example-row "},[a("h1",[t._v("Welcome to Serpwars Theme")]),a("h5",[t._v("v 1.0.0")]),a("div",{staticClass:"spacer"}),t.installerData.showMessage?a("div",{staticClass:"alert alert-primary",attrs:{role:"alert"}},[t._v(" "+t._s(t.installerData.message)+" "),a("b-progress",{attrs:{value:t.installerData.progress,max:t.max,variant:"info","show-progress":"",animated:""}})],1):t._e(),a("div",{staticClass:"spacer"}),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 plugins"},[t._v("Plugins")]),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 ml-2 mr-2 templates"},[t._v("Templates")]),a("button",{staticClass:"btn btn-default btn-lg border border-secondary mb-2 options"},[t._v("Options")]),a("div",{staticClass:"siema"},[a("div",[a("plugin-states")],1),a("div",[a("elementor-templates")],1),a("div",[a("advance-custom-field-entries")],1),a("div",[a("button",{staticClass:"btn btn-danger btn-lg border border-secondary mb-2 options",on:{click:t.uninstall}},[t._v("Uninstall features")])])])])],1)},l=[],i=(a("96cf"),a("1da1")),r=a("5530"),o=a("e30e"),u=a.n(o),c=a("2f62"),p=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-list-group",t._l(t.$store.state.loadedData.plugins,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[a("label",{class:{"text-success":e.isActive&&e.isInstalled,"text-primary":!e.isActive&&e.isInstalled,"text-danger":!e.isActive&&!e.isInstalled},attrs:{for:""}},[e.isActive?t._e():a("input",{directives:[{name:"model",rawName:"v-model",value:t.pluginPicked,expression:"pluginPicked"}],attrs:{type:"checkbox"},domProps:{value:e,checked:Array.isArray(t.pluginPicked)?t._i(t.pluginPicked,e)>-1:t.pluginPicked},on:{change:function(a){var n=t.pluginPicked,s=a.target,l=!!s.checked;if(Array.isArray(n)){var i=e,r=t._i(n,i);s.checked?r<0&&(t.pluginPicked=n.concat([i])):r>-1&&(t.pluginPicked=n.slice(0,r).concat(n.slice(r+1)))}else t.pluginPicked=l}}}),t._v(" "+t._s(e.name)+" "),""!=e.status?a("div",{staticClass:"spinner-border spinner-border-sm text-dark",attrs:{role:"status"}},[a("span",{staticClass:"sr-only"},[t._v("Loading...")])]):t._e()]),""!=e.status?a("span",[a("b-badge",{attrs:{variant:"info"}},[t._v(t._s(e.status))])],1):a("span",[e.isActive&&e.isInstalled?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Activated")]):t._e(),!e.isActive&&e.isInstalled?a("b-badge",{attrs:{variant:"primary",pill:""}},[t._v("Installed")]):t._e(),e.isActive||e.isInstalled?t._e():a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)])})),1),a("br"),t.installerData.canInstall?a("button",{staticClass:"btn btn-success btn-block",on:{click:t._processPlugins}},[t._v("Install Plugins")]):t._e()],1)},d=[],g={name:"PluginStates",data:function(){return{picked:[]}},methods:Object(r["a"])({},Object(c["b"])(["_processPlugins"])),computed:Object(r["a"])({},Object(c["c"])(["installerData"]),{pluginPicked:{get:function(){return this.$store.state.pluginPicked},set:function(t){this.$store.commit("setPluginPicked",t)}}})},m=g,f=a("2877"),_=Object(f["a"])(m,p,d,!1,null,null,null),v=_.exports,b=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("b-row",[a("b-col",{attrs:{cols:"6"}},[a("h4",[t._v("Advance Custom Fields")]),a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.acf,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.title)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1)],1),a("b-col",{attrs:{cols:"6"}},[a("h4",[t._v("Custom Post Types")]),a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.cptui,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.title)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1)],1),a("button",{staticClass:"btn btn-success btn-block mt-3",on:{click:t.install}},[t._v("Install Options")])],1)},h=[],D={name:"AdvanceCustomFieldEntries",methods:Object(r["a"])({},Object(c["b"])("PluginPost",["loadOptions","getItems","getCPTStatus","install"])),created:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.loadOptions();case 2:case"end":return e.stop()}}),e)})))()}},P=D,I=Object(f["a"])(P,b,h,!1,null,null,null),x=I.exports,y=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-list-group",t._l(t.$store.state.PluginPost.pluginSettings.elementor_templates,(function(e){return a("b-list-group-item",{staticClass:"d-flex justify-content-between align-items-center"},[t._v(" "+t._s(e.name)+" "),void 0==e.found?a("b-badge",{attrs:{variant:"default",pill:""}},[t._v("Loading")]):e.found?a("b-badge",{attrs:{variant:"success",pill:""}},[t._v("Installed")]):a("b-badge",{attrs:{variant:"danger",pill:""}},[t._v("Not Installed")])],1)})),1),a("br"),t.PluginPost.isInstalling?t._e():a("button",{staticClass:"btn btn-success btn-block",on:{click:t.importTemplates}},[t._v("Import Templates")])],1)},w=[],S={name:"ElementorTemplates",methods:Object(r["a"])({},Object(c["b"])("PluginPost",["getElementorTemplatesStatus","importTemplates"])),computed:Object(r["a"])({},Object(c["c"])(["PluginPost"])),created:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return console.log(t),e.next=3,t.getElementorTemplatesStatus();case 3:case"end":return e.stop()}}),e)})))()}},k=S,j=Object(f["a"])(k,y,w,!1,null,null,null),O=j.exports,T=a("a06b"),A=a.n(T),C={name:"App",data:function(){return{value:45,max:100,mySiema:{}}},components:{PluginStates:v,AdvanceCustomFieldEntries:x,ElementorTemplates:O},computed:Object(r["a"])({},Object(c["c"])(["installerData"])),methods:Object(r["a"])({},Object(c["b"])(["loadData","install","uninstall"])),created:function(){var t=this;return Object(i["a"])(regeneratorRuntime.mark((function e(){var a,n,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.loadData();case 2:t.mySiema=new A.a,a=document.querySelector(".plugins"),n=document.querySelector(".templates"),s=document.querySelector(".options"),a.addEventListener("click",(function(){return t.mySiema.goTo(0)})),n.addEventListener("click",(function(){return t.mySiema.goTo(1)})),s.addEventListener("click",(function(){return t.mySiema.goTo(2)}));case 9:case"end":return e.stop()}}),e)})))()}},E=C,F=(a("034f"),Object(f["a"])(E,s,l,!1,null,null,null)),$=F.exports,M=(a("b64b"),a("53ca")),q=a("bc3a"),L=a.n(q),R=a("4328"),H=a.n(R),J=(a("4160"),a("b0c0"),a("159b"),a("0804"),serpwars_setup_params.ajaxurl||"http://localhost/custom-site/wp-admin/admin-ajax.php");n["default"].use(c["a"]);var N={namespaced:!0,state:{canImportTemplates:!0,isInstalling:!1,template_imports:{currentIndex:-1,list:[],queue:[],template_install:[]},pluginSettings:{elementor_templates:[],acf:[],cptui:[]}},actions:{loadOptions:function(t){var e=t.state,a=t.dispatch;L.a.post(J,H.a.stringify({action:"serpwars_load_options"})).then((function(t){e.pluginSettings=t.data.data,console.log(t.data.data),a("getItems"),a("getCPTStatus"),a("getElementorTemplatesStatus")}))},getItems:function(t){var e=t.state;e.pluginSettings.acf.forEach((function(t,a){L.a.post(J,H.a.stringify({action:"serpwars_check_post_exists",id:t.id})).then((function(t){n["default"].set(e.pluginSettings.acf[a],"found",t.data.success)}))}))},getElementorTemplatesStatus:function(t){var e=t.state;console.log(e.pluginSettings.elementor_templates),e.pluginSettings.elementor_templates.forEach((function(t,a){0!=t.id?L.a.post(J,H.a.stringify({action:"serpwars_check_template_exists",id:t.id})).then((function(t){t.data.data.found?(n["default"].set(e.pluginSettings.elementor_templates[a],"found",!0),e.canImportTemplates=!1):(e.template_imports.list.push(e.pluginSettings.elementor_templates[a]),e.canImportTemplates=!0,n["default"].set(e.pluginSettings.elementor_templates[a],"found",!1))})):(n["default"].set(e.pluginSettings.elementor_templates[a],"found",!1),e.canImportTemplates=!0,e.template_imports.list.push(e.pluginSettings.elementor_templates[a]))}))},getCPTStatus:function(t){var e=t.state;e.pluginSettings.cptui.forEach((function(t,a){L.a.post(J,H.a.stringify({action:"serpwars_check_cpt_exists",slug:t.slug})).then((function(t){n["default"].set(e.pluginSettings.cptui[a],"found",t.data.success)}))}))},install:function(t){var e=t.state,a=t.dispatch;u()({text:"Installing Options",duration:3e3,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #000099, #0000aa)",stopOnFocus:!0}).showToast(),L.a.post(J,H.a.stringify({action:"serpwars_import_acf_options"})).then((function(t){e.pluginSettings.acf=t.data.data.acf,e.pluginSettings.cptui=t.data.data.cptui,a("getCPTStatus"),t.data.acf[0].id?u()({text:"All Options were installed",duration:3e3,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #009900, #00aa00)",stopOnFocus:!0}).showToast():a("install")}))},importTemplates:function(t){var e=t.state,a=t.dispatch;e.isInstalling=!0,L.a.post(J,H.a.stringify({action:"serpwars_import_templates"})).then((function(t){e.template_imports.queue=t.data.data,e.template_imports.currentIndex=0;for(var n=0;n<e.template_imports.queue.length;n+=1)for(var s=0;s<e.template_imports.list.length;s+=1)e.template_imports.queue[n].name==e.template_imports.list[s].name&&e.template_imports.template_install.push(e.template_imports.queue[n]);a("importTemplate")}))},importTemplate:function(t){var e=t.state,a=t.dispatch;if(e.canImportTemplates&&e.template_imports.template_install[e.template_imports.currentIndex]){var n=e.template_imports.template_install[e.template_imports.currentIndex];u()({text:"Installing "+n.name+" Template",duration:3e3,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #000099, #0000aa)",stopOnFocus:!0}).showToast(),console.log(e.pluginSettings.elementor_templates[e.template_imports.currentIndex]);var s=n.template;L.a.post(J,H.a.stringify({action:"serpwars_import_elementor_templates",url:s,name:n.name,index:e.template_imports.currentIndex})).then((function(t){for(var s=0;s<e.pluginSettings.elementor_templates.length;s+=1)e.pluginSettings.elementor_templates[s].name==e.template_imports.template_install[e.template_imports.currentIndex].name&&(e.pluginSettings.elementor_templates[s].found=!0);e.template_imports.currentIndex+=1,u()({text:n.name+" Template Installed",duration:3e3,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #009900, #00aa00)",stopOnFocus:!0}).showToast(),a("importTemplate")}))}else u()({text:"All templates were Imported",duration:3e3,close:!1,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #009900, #00aa00)",stopOnFocus:!0}).showToast(),e.isInstalling=!1}}};if(n["default"].use(c["a"]),!B)var B={onbefore_text:"Please do not refresh or leave the page during the wizard's process.",ajaxurl:"http://localhost/custom-site/wp-admin/admin-ajax.php"};var U=B.ajaxurl,X=U,z=new c["a"].Store({modules:{PluginPost:N},state:{pluginPicked:[],installerData:{progress:0,currentItemHash:"",_attemptsBuffer:0,currentIndex:0,_ajaxData:{},_ajaxUrl:B.ajaxurl,_currentItem:void 0,canInstall:!0,showMessage:!1,message:B.onbefore_text},loadedData:{plugins:[],templates:[],pluginSettings:{acf:[{id:331,title:"General Pages"},{id:337,title:"Icon Field"},{id:339,title:"Industry Pages"},{id:385,title:"Services Pages"}]}}},mutations:{setData:function(t,e){t.loadedData.plugins=e;for(var a in t.loadedData.plugins)(t.loadedData.plugins[a].isChecked&&!t.loadedData.plugins[a].isActive||t.loadedData.plugins[a].isInstalled&&!t.loadedData.plugins[a].isActive)&&t.pluginPicked.push(t.loadedData.plugins[a]);t.pluginPicked.length||(t.installerData.canInstall=!1)},setPluginPicked:function(t,e){t.pluginPicked=e}},actions:{setPluginStatus:function(t,e){var a=t.state;if(a.installerData._currentItem){var n=a.installerData._currentItem.slug;a.loadedData.plugins[n].status=e}},activate:function(t,e){var a=t.state;a.loadedData.plugins[e].isInstalled=!0,a.loadedData.plugins[e].status="",a.loadedData.plugins[e].isActive=!0},loadData:function(t){L.a.post(U,H.a.stringify({action:"serpwars_get_plugin_status"})).then((function(e){t.commit("setData",e.data.data)}))},uninstall:function(t){L.a.post(U,H.a.stringify({action:"serpwars_uninstall_features"})).then((function(e){t.commit("setData",e.data.data)}))},loadThemeAssets:function(t){L.a.post(U,H.a.stringify({action:"serpwars_get_theme_assets"})).then((function(e){t.commit("setData",e.data.data)}))},installPickedPlugins:function(t){var e=t.state,a=t.dispatch;e.installerData.canInstall=!1,e.installerData.showMessage=!0,a("_installPlugins")},_installPlugins:function(t){var e=t.state,a=t.dispatch,n=[];for(var s in e.loadedData.plugins)e.loadedData.plugins[s].isActive||n.push(s);e.installerData._currentItem&&(e.installerData_ajaxData={action:"serpwars_setup_plugins",wpnonce:B.wpnonce,slug:e.installerData._currentItem.slug,plugins:n},a("setPluginStatus","Downloading"),a("_globalAJAX",(function(t){500==t.data.status?a("setPluginStatus","Failed"):a("_pluginActions",t.data)})))},_globalAJAX:function(t,e){var a=t.state;L.a.post(X,H.a.stringify(a.installerData_ajaxData)).then((function(t){return t})).then(e)},_pluginActions:function(t,e){var a=t.state,n=t.dispatch;if("object"===Object(M["a"])(e)&&e.success)if(n("setPluginStatus",e.data.message),"Activated"==e.data.message)n("activate",a.installerData._currentItem.slug),a.installerData._currentItem=null,n("_processPlugins");else if("undefined"!==typeof e.data.url)a.installerData.currentItemHash==e.data.hash?(n("setPluginStatus","Failed"),a.installerData.currentItemHash=null,n("_installPlugins")):(X=e.data.url,a.installerData_ajaxData=e.data,a.installerData.currentItemHash=e.data.hash,e.data.url&&a.installerData._currentItem?(console.log(e.data.url),L.a.post(e.data.url,H.a.stringify(a.installerData_ajaxData)).then((function(t){return t})).then((function(t){X=U,console.log(e.data),n("activate",a.installerData._currentItem.slug),n("_installPlugins")}))):n("_globalAJAX",(function(t){a.installerData._ajaxUrl=B.ajaxurl,n("_installPlugins")})));else for(var s in a.installerData._currentItem.isInstalled=!0,a.loadedData.plugins)s==a.installerData._currentItem.slug&&(a.loadedData.plugins[s].isChecked=!1,a.loadedData.plugins[s].isDone=!0,a.loadedData.plugins[s].status="",n("_processPlugins"));else a.installerData._attemptsBuffer>1?(a.installerData._attemptsBuffer=0,n("setPluginStatus","Failed"),n("_processPlugins")):(a.installerData.currentItemHash=null,a.installerData._attemptsBuffer+=1,n("_installPlugins"))},unselectItem:function(t,e){var a=t.state;a.loadedData.plugins[e].isChecked=!1},_processPlugins:function(t){var e=t.state,a=t.dispatch,n=!1,s=0;for(var l in e.installerData.canInstall=!1,e.installerData.showMessage=!0,e.loadedData.plugins){var i=e.loadedData.plugins[l];(null==e.installerData._currentItem||n)&&(i.isActive?i.slug==l&&(a("unselectItem",l),n=!0):(console.log("Installing "+l),e.installerData.currentIndex=l,e.installerData._currentItem=e.loadedData.plugins[l],console.log(e.installerData._currentItem),a("_installPlugins"),n=!1))}var r=Object.keys(e.loadedData.plugins);for(var l in e.loadedData.plugins)e.loadedData.plugins[l].isActive&&(s+=1),e.installerData.progress=s/r.length*100,console.log(e.installerData.progress+" "+s+" "+r.length);100==parseInt(e.installerData.progress)&&(u()({text:"All Plugins were successfully installed",duration:3e3,close:!0,gravity:"top",position:"right",backgroundColor:"linear-gradient(to right, #009900, #00aa00)",stopOnFocus:!0}).showToast(),e.installerData.showMessage=!1)}}}),G=a("5f5b"),W=a("b1e0");a("f9e3"),a("2dd8"),a("becf");n["default"].use(G["a"]),n["default"].use(W["a"]),n["default"].config.productionTip=!1;new n["default"]({store:z,render:function(t){return t($)}}).$mount("#app")},"85ec":function(t,e,a){}});
//# sourceMappingURL=app.38db1f67.js.map