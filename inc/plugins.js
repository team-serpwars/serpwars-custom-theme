(function($){

	console.log(aux_setup_params);

	var  _ajaxData = {};
	var currentItemHash,_ajaxUrl,_attemptsBuffer,_attemptsBuffer;
	var currentIndex=0;
	var slug = "elementor"	

	var pluginsList = [
		{
			slug:'elementor',
			isChecked:true,
			isDone:false,
			inProgress:false,
		},
		{
			slug:'custom-post-type-ui',
			isChecked:true,
			isDone:false,
			inProgress:false,
		},
		{
			slug:'advanced-custom-fields',
			isChecked:true,
			isDone:false,
			inProgress:false,
		},
		{
			slug:'font-awesome',
			isChecked:true,
			isDone:false,
			inProgress:false,
		},
		{
			slug:'dynamicconditions',
			isChecked:true,
			isDone:false,
			inProgress:false,
		}
	];

	var plugins = pluginsList.map(function(e){return e.slug});
	var _currentItem = null;

	for(var i in pluginsList){
		if(pluginsList[i].isChecked==true && !pluginsList[i].isDone &&  _currentItem == null){
			_currentItem = pluginsList[i].slug;
		}
	}



	console.log(_currentItem);

	var _globalAJAX= function(callback) {
            // Do Ajax & update default value

    		console.log(_ajaxUrl)
            $.ajax({
                url: aux_setup_params.ajaxurl,
                type: "post",
                data: _ajaxData
            }).done(callback);
       }

    var _installPlugin= function() {
    	var plugins = pluginsList.map(function(e){ if (e.ischecked) return e.slug });
    	console.log("installing "+_currentItem);
            if (_currentItem) {                
                _ajaxData = {
                    action: "serpwars_setup_plugins",
                    wpnonce: aux_setup_params.wpnonce,
                    slug: _currentItem,
                    plugins: plugins
                };
                
                _globalAJAX(
                    function(response) {
                        _pluginActions(response);
                    }
                );
            }
        }

    var _pluginActions = function(response) {

            if (typeof response === "object" && response.success) {
                // Update plugin status message
                
                // At this point, if the response contains the url, it means that we need to install/activate it.
                if (typeof response.data.url !== "undefined") {

                    if (currentItemHash == response.data.hash) {
                        console.log("Failed")
                        currentItemHash = null;
                        _installPlugin();
                    } else {
                        // we have an ajax url action to perform.
                        _ajaxUrl = response.data.url;
                        _ajaxData = response.data;
                        currentItemHash = response.data.hash;

                        if(response.data.url){
                        	$.ajax({
            				    url: response.data.url,
            				    type: "post",
            				    data: _ajaxData
            				}).done(function(html) {
                                // Reset ajax url to default admin ajax value
                                _ajaxUrl = aux_setup_params.ajaxurl;
                                _installPlugin();
                            });

                        }else{

                        _globalAJAX(
                            function(html) {
                                // Reset ajax url to default admin ajax value
                                _ajaxUrl = aux_setup_params.ajaxurl;
                                _installPlugin();
                            }
                        );
                        }
                    }
                } else {
                    // otherwise it's just installed and we should make a notify to user
                    // update isChecked
                     pluginsList.forEach(function(e){ 
                     	if(e.slug==_currentItem){
                     		// e.isChecked = false;
                     		e.isDone = true;
                     		currentIndex+=1;

                     	}
                     });
                    console.log(_currentItem + " Is Already Installed")
                    // Then jump to next plugin
                    _processPlugins();
                }
            } else {
                // If there is an error, we will try to reinstall plugin twice with buffer checkup.
                if (_attemptsBuffer > 1) {
                    // Reset buffer value
                    _attemptsBuffer = 0;
                    // error & try again with next plugin
                    console.log("AJAX Error")
                    _processPlugins();
                } else {
                    // Try again & update buffer value
                    currentItemHash = null;
                    _attemptsBuffer++;
                    _installPlugin();
                }
            }
        }

       var _processPlugins = function() {
            var doNext = false,
                $pluginsList =  pluginsList.map(function(e){ if(e.ischecked) return  e;});

                console.log(_currentItem);

            var done_counter = 0;
            // Scroll on each progress in modal view
            

            pluginsList.forEach(function(item) {
                if (_currentItem == null || doNext) {
                    if (item.isChecked) {
                    	item.inProgress = true
                        _currentItem = item.slug;
                        _installPlugin();
                        doNext = false;
                    }
                } else if (item.slug === _currentItem) {
                    item.inProgress = false;
                    doNext = true;

                }
            });
            pluginsList.forEach(function(item) {
                if (item.isChecked && item.isDone) {
                	done_counter+=1
                }
            });

            if(done_counter == $pluginsList.length){
            	console.log("All Items were installed")
            }          
        }



	$("body").on("click","a.install-plugins",function(e){
		console.log("Initialize Plugin Installation");
		e.preventDefault();
		// $.post(ajaxurl,{action:"serpwars_setup_plugins",slug:"font-awesome",nonce:aux_setup_params.wpnonce,plugins:['font-awesome','elementor']},function(data){
		// 		console.log(data)
		// })		

		_installPlugin();
	})
	$("body").on("click","a.demo-importer",function(e){
		console.log("Initialize Demo Importer");
		$.ajax({
                url: aux_setup_params.ajaxurl,
                type: "post",
                data: {
                	action:"serpwars_demo_data",

                }
            }).done(callback);
	})
					
					
})(jQuery)