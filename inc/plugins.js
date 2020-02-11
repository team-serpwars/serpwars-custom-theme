(function($){

	console.log(aux_setup_params);

	var  _ajaxData = {};
	var currentItemHash,_ajaxUrl,_attemptsBuffer,_attemptsBuffer;
	var slug = "elementor"
	var plugins = ['elementor','custom-post-type-ui','advanced-custom-fields','font-awesome','dynamicconditions'];

	var _globalAJAX= function(callback) {
            // Do Ajax & update default value

            $.ajax({
                url: aux_setup_params.ajaxurl,
                type: "post",
                data: _ajaxData
            }).done(callback);
       }

    var _installPlugin= function(slug) {

    	console.log(aux_setup_params.wpnonce);
            if (slug) {                
                _ajaxData = {
                    action: "serpwars_setup_plugins",
                    wpnonce: aux_setup_params.wpnonce,
                    slug: slug,
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
            // Check response type
            if (typeof response === "object" && response.success) {
                // Update plugin status message
              

                console.log(response)
                // At this point, if the response contains the url, it means that we need to install/activate it.
                if (typeof response.data.url !== "undefined") {
                    	console.log("Then What ?")
                    if (currentItemHash == response.data.hash) {
                    	console.log("Done 0")
                        // $currentNode
                        //     .data("done_item", 0)
                        //     .find(".column-status span")
                        //     .text("failed");
                        currentItemHash = null;
                        _installPlugin();
                    } else {
                        // we have an ajax url action to perform.

                        _ajaxUrl = response.data.url;
                        console.log(response.data.url)
                        _ajaxData = response.data;
                        currentItemHash = response.data.hash;

                        console.log(currentItemHash)
                        $.ajax({
                url: _ajaxUrl,
                type: "post",
                data: _ajaxData
            }).done(_installPlugin);
                        // _globalAJAX(
                        //     function(html) {
                        //         // Reset ajax url to default admin ajax value
                        //         _ajaxUrl = aux_setup_params.ajaxurl;
                        //         _installPlugin();
                        //     }
                        // );
                    }
                } else {
                    // otherwise it's just installed and we should make a notify to user
                                console.log("Check")
                   
                    // Then jump to next plugin
                    _processPlugins();
                }
            } else {
                // If there is an error, we will try to reinstall plugin twice with buffer checkup.
                if (_attemptsBuffer > 1) {
                    // Reset buffer value
                    _attemptsBuffer = 0;
                    // error & try again with next plugin
                    console.log("Error")
                   
                    _processPlugins();
                } else {
                    // Try again & update buffer value
                    currentItemHash = null;
                    _attemptsBuffer++;
                    _installPlugin();
                }
            }
        }



	$("body").on("click","a.install-plugins",function(e){
		console.log("cloickpasjd");
		e.preventDefault();
		// $.post(ajaxurl,{action:"serpwars_setup_plugins",slug:"font-awesome",nonce:aux_setup_params.wpnonce,plugins:['font-awesome','elementor']},function(data){
		// 		console.log(data)
		// })		

		_installPlugin('elementor');
	})
					
					
})(jQuery)