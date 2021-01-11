(function () {
    var _id = "27354497898b961ab8e7991e6e09677d";
    while (document.getElementById("timer" + _id)) _id = _id + "0";
    document.write("<div id='timer" + _id + "' style='height:74px;'></div>");
    var _t = document.createElement("script");
    _t.src = "//megatimer.ru/timer/timer.min.js?v=1";
    var _f = function (_k) {
        const fontSize = window.screen.width <= '768' ? "24": "60";
        var l = new MegaTimer(_id, {
            "view": [1, 1, 1, 1],
            "type": {"currentType": "1", "params": {"usertime": true, "tz": "3", "utc": 1605830340000}},
            "design": {
                "type": "plate",
                "params": {
                    "round": "0",
                    "background": "opacity",
                    "effect": "slide",
                    "space": "2",
                    "separator-margin": "21",
                    "number-font-family": {
                        "family": "Roboto",
                        "link": "<link href='//fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"
                    },
                    "number-font-size": fontSize,
                    "number-font-color": "#0c5da5",
                    "padding": "0",
                    "separator-on": true,
                    "separator-text": ":",
                    "text-on": true,
                    "text-font-family": {
                        "family": "Roboto",
                        "link": "<link href='//fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"
                    },
                    "text-font-size": "12",
                    "text-font-color": "#0c5da5"
                }
            },
            "designId": 4,
            "theme": "white",
            "width": 448,
            "height": 74
        });
        if (_k != null) l.run();
    };
    _t.onload = _f;
    _t.onreadystatechange = function () {
        if (_t.readyState == "loaded") _f(1);
    };
    var _h = document.head || document.getElementsByTagName("head")[0];
    _h.appendChild(_t);
}).call(this);