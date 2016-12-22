
        // Begins assignment of observer observer_manager{id}
        var head = document.getElementsByTagName('head')[0];
        var script = document.createElement('script');
        script.type = "text/javascript";
        script.src = "{JSFRAMEWORK}mvc.controller.getstate.js";
        script.id = "observer_manager{id}";

        polling = document.createAttribute("data-polling");
        polling.value ="{polling_interval}";
        script.setAttributeNode(polling);

        content = document.createAttribute("data-content");
        content.value ="{content_check}";
        script.setAttributeNode(content);

        postdata = document.createAttribute("data-post");
        postdata.value ="{serialized_post}";
        script.setAttributeNode(postdata);

        alertdata = document.createAttribute("data-alert");
        alertdata.value ="{alert_flag}";
        script.setAttributeNode(alertdata);

        head.appendChild(script);
        // Ends assignment of observer observer_manager{id}

        var serverOSEncoding = "{SERVER_OS_ENCODING}";
