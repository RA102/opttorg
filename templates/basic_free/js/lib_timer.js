(function () {
    var n = function (t, e) {
        return function () {
            return t.apply(e, arguments)
        }
    }, u = [].indexOf || function (t) {
        for (var e = 0, i = this.length; e < i; e++) if (e in this && this[e] === t) return e;
        return -1
    }, o = {}.hasOwnProperty;
    this.flipchartCss = '<link href="//megatimer.ru/timer/timer.min.css?v=3" rel="stylesheet" type="text/css">', this.MegaTimer = function () {
        var r, a, h, s;

        function t(t, e) {
            var i, a;
            this.plateTick = n(this.plateTick, this), this.circleTick = n(this.circleTick, this), this.newTime = n(this.newTime, this), this.id = t, this.params = e, this.timerElements = this.cloneObject(s), this.tickEvent = [], r(window, "load", (i = this, function () {
                return i.run()
            })), r(window, "focus", (a = this, function () {
                return a.initType(), a.newTime(!0)
            }))
        }

        return s = {
            secundes: {max: 60, min: 0, text: "СЃРµРєСѓРЅРґ", value: 0, view: !(a = null), updated: !(h = [])},
            minutes: {max: 60, min: 0, text: "РјРёРЅСѓС‚", value: 0, view: !0, updated: ![]},
            hours: {max: 24, min: 0, text: "С‡Р°СЃРѕРІ", value: 0, view: !0, updated: !1},
            days: {max: 1e3, min: 0, text: "РґРЅРµР№", value: 0, view: !0, updated: !1}
        }, t.prototype.destroy = function () {
            return null != this.interval && clearInterval(this.interval), null != this.container && (this.container.innerHTML = ""), $("#timer-" + this.id + "-style").remove(), h = []
        }, t.prototype.run = function () {
            var t, e, i, a, r, s, n, o, l, p, m, d;
            if (null != this.id && (d = this.id, u.call(h, d) < 0) && (h.push(this.id), this.initView(), this.initType(), null != this.id)) {
                for (i in this.container = document.getElementById("timer" + this.id), e = !(this.container.innerHTML = ""), a = [], this.timerElements) a.push(i);
                for (a.reverse(), this.showText = this.params.design.params["text-on"], null == this.showText && (this.showText = !1), p = 0, m = a.length; p < m; p++) l = a[p], (r = document.createElement("span")).id = "timer-number-" + this.id + "-" + l, (s = document.createElement("span")).id = "timer-number-value-" + this.id + "-" + l, r.appendChild(s), (o = document.createElement("span")).id = "timer-text-" + this.id + "-" + l, o.innerHTML = this.timerElements[l].text, (t = document.createElement("span")).className = "timer-element", t.id = "timer-element-" + this.id + "-" + l, t.appendChild(r), t.appendChild(o), e ? e = !1 : ((n = document.createElement("span")).className = "timer-separator", n.id = "timer-separator-" + this.id + "-" + l, this.container.appendChild(n)), this.container.appendChild(t);
                return this.initDesign(), this.newTime(!0), this.interval = setInterval(this.newTime, 1e3)
            }
        }, t.prototype.initDesign = function () {
            if (null != this.params.design) {
                null != this.getIEVersion() && this.getIEVersion() < 9 && (this.params.design.type = "text");
                var t = this.params.design.type;
                (null == t || "text" !== t && "plate" !== t && "circle" !== t) && (t = "text"), t = t.charAt(0).toUpperCase() + t.substr(1), this.initCommonDesign(), this["init" + t + "Design"]()
            }
        }, t.prototype.initCommonDesign = function () {
            var t, e, i, a, r, s;
            for (r in this.container.style.textAlign = "center", this.container.style.webkitTransform = "translate3d(0,0,0)", s = [], this.timerElements) t = document.getElementById("timer-element-" + this.id + "-" + r), e = document.getElementById("timer-number-" + this.id + "-" + r), a = document.getElementById("timer-text-" + this.id + "-" + r), i = document.getElementById("timer-separator-" + this.id + "-" + r), t.style.display = "inline-block", e.style.display = "inline-block", a.style.display = this.showText ? "block" : "none", t.style.lineHeight = 1, e.style.lineHeight = 1, a.style.lineHeight = 1, this.setMargin(t, 0), this.setMargin(e, 0), this.setMargin(a, 0), null != i && (i.style.display = "inline", i.style.verticalAlign = "top", i.style.lineHeight = 1, this.setMargin(i, 0)), this.timerElements[r].view ? s.push(void 0) : (t.style.display = "none", e.style.display = "none", a.style.display = "none", null != i ? s.push(i.style.display = "none") : s.push(void 0));
            return s
        }, t.prototype.initTextDesign = function () {
            var t, e, i, a, r;
            for (r in e = [], a = [], this.timerElements) e.push(document.getElementById("timer-number-" + this.id + "-" + r)), null != (i = document.getElementById("timer-text-" + this.id + "-" + r)) && (a.push(i), null != this.params.design.params["text-margin"] && ("auto" !== (t = this.params.design.params["text-margin"]) && (t = parseInt(t) + "px"), i.style.marginTop = t));
            return this.setFonts(e, "number"), this.setFonts(a, "text"), this.setSeparators()
        }, t.prototype.initCircleDesign = function () {
            var t, e, i, a, r, s, n, o, l, p;
            for (l in r = [], o = [], this.timerElements) r.push(document.getElementById("timer-number-" + this.id + "-" + l)), null != (n = document.getElementById("timer-text-" + this.id + "-" + l)) && (o.push(n), null != this.params.design.params["text-margin"] && ("auto" !== (a = this.params.design.params["text-margin"]) && (a = parseInt(a) + "px"), n.style.marginTop = a));
            for (l in this.setFonts(r, "number"), this.setFonts(o, "text"), this.setSeparators(), this.container.style.display = "table", this.params.design.params.radius < 0 && (this.params.design.params.radius = 0), this.params.design.params.width < 0 && (this.params.design.params.width = 0), p = 2 + 2 * (parseInt(this.params.design.params.radius) + parseInt(this.params.design.params.width)), this.timerElements) this.timerElements[l].view && ((t = document.createElement("canvas")).id = "timer-canvas-" + this.id + "-" + l, t.style.position = "absolute", t.style.left = 0, t.style.right = 0, t.style.top = 0, t.style.bottom = 0, t.width = p, t.height = p, (e = document.createElement("span")).appendChild(t), (i = document.getElementById("timer-element-" + this.id + "-" + l)).appendChild(e), i.style.position = "relative", i.style.display = "table-cell", i.style.width = p + "px", i.style.height = p + "px", i.style.verticalAlign = "middle", null != (s = document.getElementById("timer-separator-" + this.id + "-" + l)) && (s.style.height = p + "px", s.style.verticalAlign = "middle", "none" !== s.style.display.toLowerCase() && (s.style.display = "table-cell")));
            return this.container.style.marginTop = 0, this.container.style.marginRight = "auto", this.container.style.marginBottom = 0, this.container.style.marginLeft = "auto", "opacity" === this.params.design.params.background && (this.params.design.params["background-color"] = "opacity"), this.circleTick(), this.tickEvent.push(this.circleTick)
        }, t.prototype.initPlateDesign = function () {
            var t, e, i, a, r, s, n, o, l, p, m, d, h, u, c, g, f, y, b;
            switch (t = function (t, e, i) {
                var a, r, s, n;
                switch (null == i && (i = !1), n = f.params.design.params.effect, (r = document.createElement("span")).id = "timer-number-" + n + e + "-" + f.id + "-" + t, r.className = "timer-" + n + "-inner", i && null != f.params.design.params.space && ((s = parseInt(f.params.design.params.space)) <= 0 && (s = 1), r.style.marginRight = s + "px"), a = 8, null != f.params.design.params["number-font-family"] && null != f.params.design.params["number-font-family"].family && "Poiret One" === f.params.design.params["number-font-family"].family && (a = 0), n) {
                    case"flipchart":
                        r.innerHTML = "<span class='timer-flipchart-card' style='display:none;'><span class='timer-flipchart-front timer-flipchart-face'></span><span class='timer-flipchart-back timer-flipchart-face'></span><span class='timer-flipchart-top timer-flipchart-face'></span><span class='timer-flipchart-bottom timer-flipchart-face'></span><span class='timer-flipchart-bounding'>" + a + "</span></span>";
                        break;
                    case"slide":
                        r.innerHTML = "<span class='timer-slide-old'></span><span class='timer-slide-new'></span><span class='timer-slide-bounding' style='visibility: hidden;'>" + a + "</span>"
                }
                return r
            }, e = function (t, e, i, a) {
                return null == i && (i = ""), null == a && (a = null), null != y.params.design.params[e] || null != a ? (null == a && (a = y.params.design.params[e]), t + ":" + a + i + ";") : ""
            }, r = function (t) {
                var e;
                return null != (e = b.params.design.params[t]) && (e = h(e), b.params.design.params[t] = e), e
            }, h = function (t) {
                var e;
                return null != t && t.match(/^rgba\(.*\)/) && (e = /^rgba\((\d+),\s*(\d+),\s*(\d+),(.*)\)$/, t = t.replace(e, "rgb($1,$2,$3)")), t
            }, o = function (t, e) {
                return "background: " + t + "; /* Old browsers */ background: -moz-linear-gradient(top, " + t + " 0%, " + e + " 100%); /* FF3.6+ */ background: -webkit-gradient(linear, left top, left bottom, color-stop(0%," + t + "), color-stop(100%," + e + ")); /* Chrome,Safari4+ */ background: -webkit-linear-gradient(top, " + t + " 0%," + e + " 100%); /* Chrome10+,Safari5.1+ */ background: -o-linear-gradient(top, " + t + " 0%," + e + " 100%); /* Opera 11.10+ */ background: -ms-linear-gradient(top, " + t + " 0%," + e + " 100%); /* IE10+ */ background: linear-gradient(to bottom, " + t + " 0%," + e + " 100%); /* W3C */ filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='" + t + "', endColorstr='" + e + "',GradientType=0);"
            }, d = [], c = [], (null == (n = (b = y = f = this).params.design.params.effect) || "none" !== n && "flipchart" !== n && "slide" !== n && "no-slide" !== n || !this.animationSupport()) && (n = "none"), this.params.design.params.animation = !0, "none" === n ? (this.params.design.params.effect = "flipchart", this.params.design.params.animation = !1) : "no-slide" === n && (this.params.design.params.effect = "slide", this.params.design.params.animation = !1), s = "", (null == (i = this.params.design.params.background) || "solid" !== i && "gradient" !== i && "opacity" !== i) && (i = "solid"), this.params.design.params.effect) {
                case"flipchart":
                    switch (l = s = "", i) {
                        case"opacity":
                            this.params.design.params.animation ? r("background-color") : (this.params.design.params["background-color"] = "rgba(110,110,100,0)", s += "#timer" + this.id + " .timer-flipchart-top:before, #timer" + this.id + " .timer-flipchart-front:before, #timer" + this.id + " .timer-flipchart-bottom:before, #timer" + this.id + " .timer-flipchart-back:before { opacity: 0!important; }");
                            break;
                        case"solid":
                            this.params.design.params.animation && r("background-color");
                            break;
                        case"gradient":
                            null != (a = this.params.design.params["background-color"]) && "object" == typeof a && 1 < a.length && (this.params.design.params.animation && (a[0] = h(a[0])), this.params.design.params.animation && (a[1] = h(a[1])), l = "#timer" + this.id + " .timer-flipchart-top, #timer" + this.id + " .timer-flipchart-front {" + o(a[0], a[1]) + "}#timer" + this.id + " .timer-flipchart-bottom, #timer" + this.id + " .timer-flipchart-back {" + o(a[1], a[0]) + "}")
                    }
                    s += "#timer" + this.id + " .timer-flipchart-face{" + e("background-color", "background-color") + this.getCssFonts("number") + "}#timer" + this.id + " .timer-separator{" + e("padding-top", "padding", "px!important") + e("padding-bottom", "padding", "px!important") + "}#timer" + this.id + " .timer-flipchart-bounding{" + e("padding-left", "padding", "px") + e("padding-right", "padding", "px") + e("padding-top", "padding", "px") + e("padding-bottom", "padding", "px") + "}#timer" + this.id + " .timer-flipchart-top, #timer" + this.id + " .timer-flipchart-front{" + e("padding-left", "padding", "px") + e("padding-right", "padding", "px") + e("padding-top", "padding", "px") + e("padding-bottom", "padding", "px", 0) + "}#timer" + this.id + " .timer-flipchart-bottom, #timer" + this.id + " .timer-flipchart-back{" + e("padding-left", "padding", "px") + e("padding-right", "padding", "px") + e("padding-top", "padding", "px", 0) + e("padding-bottom", "padding", "px") + "}#timer" + this.id + " .timer-flipchart-top, #timer" + this.id + " .timer-flipchart-front {" + e("border-top-left-radius", "round", "px") + e("border-top-right-radius", "round", "px") + e("border-bottom-left-radius", "", "px", 0) + e("border-bottom-right-radius", "", "px", 0) + "}#timer" + this.id + " .timer-flipchart-bottom, #timer" + this.id + " .timer-flipchart-back {" + e("border-top-left-radius", "", "px", 0) + e("border-top-right-radius", "", "px", 0) + e("border-bottom-left-radius", "round", "px") + e("border-bottom-right-radius", "round", "px") + "}#timer" + this.id + " .timer-flipchart-bottom:after {" + e("border-top-left-radius", "", "px", 0) + e("border-top-right-radius", "", "px", 0) + e("border-bottom-left-radius", "round", "px") + e("border-bottom-right-radius", "round", "px") + "}#timer" + this.id + " .timer-flipchart-front:after, #timer" + this.id + " .timer-flipchart-top:after{" + e("border-top-left-radius", "round", "px") + e("border-top-right-radius", "round", "px") + e("border-bottom-left-radius", "", "px", 0) + e("border-bottom-right-radius", "", "px", 0) + "}#timer" + this.id + " .timer-flipchart-card {" + e("border-radius", "round", "px") + "}" + l, this.params.design.params.animation || (s += "#timer" + this.id + " .timer-flipchart-top:after{display:none!important;} #timer" + this.id + " .timer-flipchart-front{display:none!important;}");
                    break;
                case"slide":
                    switch (l = "", i) {
                        case"opacity":
                            this.params.design.params["background-color"] = "rgba(110,110,100,0)";
                            break;
                        case"gradient":
                            null != (a = this.params.design.params["background-color"]) && "object" == typeof a && 1 < a.length && (l = "#timer" + this.id + " .timer-slide-new, #timer" + this.id + " .timer-slide-old {" + o(a[0], a[1]) + "}")
                    }
                    s = "#timer" + this.id + " .timer-slide-inner{" + e("border-radius", "round", "px") + e("background-color", "background-color") + this.getCssFonts("number") + "}#timer" + this.id + " .timer-separator{" + e("padding-top", "padding", "px!important") + e("padding-bottom", "padding", "px!important") + "}#timer" + this.id + " .timer-slide-bounding, #timer" + this.id + " .timer-slide-new, #timer" + this.id + " .timer-slide-old{" + e("padding-left", "padding", "px") + e("padding-right", "padding", "px") + e("padding-top", "padding", "px") + e("padding-bottom", "padding", "px") + "}" + l
            }
            for (g in this.addCssLink(flipchartCss), this.addCustomCss(s), this.timerElements) null != (m = document.getElementById("timer-number-" + this.id + "-" + g)) && (d.push(m), document.getElementById("timer-number-value-" + this.id + "-" + g).style.display = "none", "days" === g ? 0 < Math.floor(this.timerElements[g].value / 100) ? (m.appendChild(t(g, 2, !0)), m.appendChild(t(g, 1, !0))) : 0 < Math.floor(this.timerElements[g].value / 10) && m.appendChild(t(g, 1, !0)) : m.appendChild(t(g, 1, !0)), m.appendChild(t(g, 0))), null != (u = document.getElementById("timer-text-" + this.id + "-" + g)) && (c.push(u), null != this.params.design.params["text-margin"] && ("auto" !== (p = this.params.design.params["text-margin"]) && (p = parseInt(p) + "px"), u.style.marginTop = p));
            return this.setFonts(d, "number"), this.setFonts(c, "text"), this.setSeparators(), this.plateTick(), this.tickEvent.push(this.plateTick)
        }, t.prototype.setSeparators = function () {
            var t, e, i, a, r, s, n, o, l, p, m, d, h;
            for (o in t = "inline-block", i = 0, n = "", (i = this.params.design.params["separator-margin"]) <= 0 && (i = 1), n = null != this.params.design.params["separator-on"] && this.params.design.params["separator-on"] ? this.params.design.params["separator-text"] : "", r = [], s = [], l = [], this.timerElements) l.push(this.timerElements[o].view);
            for (e = p = h = l.length - 1; h <= 0 ? p <= 0 : 0 <= p; e = h <= 0 ? ++p : --p) if (l[e]) {
                l[e] = !1;
                break
            }
            for (o in e = 0, this.timerElements) null != (a = document.getElementById("timer-separator-" + this.id + "-" + o)) && r.push(a), s.push(l[e] ? t : "none"), e++;
            for (m = e = 0, d = r.length; m < d; m++) (a = r[m]).style.display = s[e], a.innerHTML = n, a.style.paddingTop = 0, a.style.paddingRight = i + "px", a.style.paddingBottom = 0, a.style.paddingLeft = i + "px", e++;
            return this.setFonts(r, "number")
        }, t.prototype.getCssFonts = function (t) {
            var e, i, a, r;
            if (null == t && (t = ""), e = "", null != this.params.design && null != this.params.design.params && (a = this.params.design.params[t + "-font-family"], r = this.params.design.params[t + "-font-size"], i = this.params.design.params[t + "-font-color"], null != r && 0 <= parseInt(r) && (e += "font-size:" + parseInt(r) + "px;"), null != i && (e += "color:" + i + ";"), null != a)) return e + "font-family:'" + (a = null != a.family ? a.family : null) + "';"
        }, t.prototype.setFonts = function (t, e) {
            var i, a, r, s, n, o, l;
            if (null == e && (e = ""), null != this.params.design && null != this.params.design.params && (a = this.params.design.params[e + "-font-family"], r = this.params.design.params[e + "-font-size"], i = this.params.design.params[e + "-font-color"], null != a && (null != a.link && this.addCssLink(a.link), a = null != a.family ? a.family : null), null != t && 0 < t.length)) {
                for (l = [], n = 0, o = t.length; n < o; n++) s = t[n], null != r && (s.style.fontSize = parseInt(r) + "px"), null != i && (s.style.color = i), null != a ? l.push(s.style.fontFamily = a) : l.push(void 0);
                return l
            }
        }, t.prototype.setMargin = function (t, e) {
            return "auto" !== e && (e = parseInt(e) + "px"), t.style.marginBottom = e, t.style.marginLeft = e, t.style.marginRight = e, t.style.marginTop = e
        }, t.prototype.initView = function () {
            var t;
            return t = [1, 1, 1, 1], null != this.params && null != this.params.view && 4 === this.params.view.length && (t = this.params.view), this.timerElements.days.view = 1 === t[0], this.timerElements.hours.view = 1 === t[1], this.timerElements.minutes.view = 1 === t[2], this.timerElements.secundes.view = 1 === t[3]
        }, t.prototype.initType = function () {
            var t, e, i, a, r, s, n, o, l, p, m, d, h, u;
            if (null != this.params && null != this.params.type && null != this.params.type.currentType && null != this.params.type.params) {
                switch (m = 0, o = new Date, parseInt(this.params.type.currentType)) {
                    case 1:
                        null != this.params.type.params.utc && (d = 0, this.params.type.params.usertime && (d = 6e4 * o.getTimezoneOffset()), l = new Date(this.params.type.params.utc + d), m = Math.round((l.getTime() - o.getTime()) / 1e3));
                        break;
                    case 2:
                        if (e = parseInt(this.params.type.params.days), r = parseInt(this.params.type.params.hours), s = parseInt(this.params.type.params.minutes), n = parseInt(this.params.type.params.seconds), (null == e || isNaN(e)) && (e = 0), (null == r || isNaN(r)) && (r = 0), (null == s || isNaN(s)) && (s = 0), (null == n || isNaN(n)) && (n = 0), this.params.type.params.startByFirst) {
                            if (a = this.getCookie("timer" + this.id), isNaN(a) && (a = null), null != a && null == (l = new Date(parseInt(a))) && (a = null), null == a) {
                                (l = new Date).setDate(l.getDate() + e), l.setHours(l.getHours() + r), l.setMinutes(l.getMinutes() + s), l.setSeconds(l.getSeconds() + n);
                                var c = l.getTime(), g = new Date(l.getTime());
                                g.setDate(g.getDate() + 3), this.setCookie("timer" + this.id, c, {
                                    expires: g,
                                    path: "/"
                                })
                            }
                        } else null != this.params.type.params.utc && ((l = new Date(this.params.type.params.utc)).setDate(l.getDate() + e), l.setHours(l.getHours() + r), l.setMinutes(l.getMinutes() + s), l.setSeconds(l.getSeconds() + n));
                        m = Math.round((l.getTime() - o.getTime()) / 1e3);
                        break;
                    case 3:
                        if (null != this.params.type.params.weekdays && null != this.params.type.params.time && null != this.params.type.params.usertime && null != this.params.type.params.hours && null != this.params.type.params.minutes) {
                            for (2 === (p = this.params.type.params.time.split(":")).length && 0 <= p[0] && p[0] <= 23 && 0 <= p[1] && p[1] <= 59 || (p = [0, 0]), h = o.getDay(), l = null, r = parseInt(this.params.type.params.hours), isNaN(r) && (r = 0), s = parseInt(this.params.type.params.minutes), isNaN(s) && (s = 0), e = Math.ceil(parseInt(this.params.type.params.hours) / 24), u = i = 0; 0 <= e ? u <= e : e <= u; i = 0 <= e ? ++u : --u) if (--h < 0 && (h = 6), 1 === this.params.type.params.weekdays[h] && ((t = new Date).setDate(t.getDate() - i), t.setHours(parseInt(p[0])), t.setMinutes(parseInt(p[1])), t.setSeconds(0), this.params.type.params.usertime || t.setTime(t.getTime() - 6e4 * o.getTimezoneOffset() + 6e4 * this.params.type.params.tz), o.getTime() >= t.getTime() && (t.setHours(t.getHours() + r), t.setMinutes(t.getMinutes() + s), t.getTime() >= o.getTime()))) {
                                l = t;
                                break
                            }
                            (m = null) != l && (m = Math.round((l.getTime() - o.getTime()) / 1e3))
                        }
                        break;
                    default:
                        this.id = null, this.params = null
                }
                return (null == m || m < 0) && (m = 0), this.timerElements.secundes.value = Math.floor(m % 60), m /= 60, this.timerElements.minutes.value = Math.floor(m % 60), m /= 60, this.timerElements.hours.value = Math.floor(m % 24), m /= 24, this.timerElements.days.value = Math.floor(m)
            }
        }, t.prototype.newTime = function (t) {
            var e, i, a, r, s, n, o, l, p, m, d;
            if (null == t && (t = !1), t || 0 !== this.timerElements.days.value || 0 !== this.timerElements.hours.value || 0 !== this.timerElements.minutes.value || 0 !== this.timerElements.secundes.value) {
                for (n in s = !t, this.timerElements) i = document.getElementById("timer-number-value-" + this.id + "-" + n), o = (a = this.timerElements[n]).value, e = !1, s && (o -= 1, e = !0), s = !1, o < a.min && (o = a.max, e = s = !0), o >= a.max && (o = a.max - 1, e = !0), a.updated = !(!e && !t) && (null != i && (i.innerHTML = o), a.value = o, !0);
                if (0 < this.tickEvent.length) {
                    for (d = [], l = 0, p = (m = this.tickEvent).length; l < p; l++) r = m[l], d.push(r());
                    return d
                }
            } else clearInterval(this.interval)
        }, t.prototype.getColorBetween = function (t, e, i) {
            var a, r, s;
            return r = function (t, e) {
                return t + Math.round((e - t) * i)
            }, s = function (t) {
                var e;
                return t = Math.min(t, 255), (e = (t = Math.max(t, 0)).toString(16)).length < 2 && (e = "0" + e), e
            }, 1 === t.a && 1 === e.a || !(null == this.getIEVersion() || this.getIEVersion() < 9) ? "#" + s(r(t.r, e.r)) + s(r(t.g, e.g)) + s(r(t.b, e.b)) : (a = (t.a + (e.a - t.a) * i).toFixed(2), "rgba(" + r(t.r, e.r) + "," + r(t.g, e.g) + "," + r(t.b, e.b) + "," + a + ")")
        }, t.prototype.getGradientColors = function (t, e, i) {
            var a, r, s, n;
            for (r = [], n = 1 / (i - 1), s = a = 0; s < i;) r[s] = this.getColorBetween(t, e, a), a += n, s++;
            return r
        }, t.prototype.hexToRgb = function (t) {
            var e, i, a, r;
            if (a = /^#?([a-f\d]{1,2})([a-f\d]{1,2})([a-f\d]{1,2})$/i.exec(t)) 1 === a[1].length && (a[1] += "" + a[1]), 1 === a[2].length && (a[2] += "" + a[2]), 1 === a[3].length && (a[3] += "" + a[3]), a = {
                r: parseInt(a[1], 16),
                g: parseInt(a[2], 16),
                b: parseInt(a[3], 16),
                a: 1
            }; else if (0 === t.indexOf("rgb")) if (2 < (e = t.match(/\d+(\.\d+)?%?/g)).length) {
                for (i = r = 0; r <= 2; i = ++r) e[i] < 0 && (e[i] = 0), 255 < e[i] && (e[i] = 255);
                a = {r: parseInt(e[0]), g: parseInt(e[1]), b: parseInt(e[2]), a: 1}
            } else a = {r: 0, g: 0, b: 0, a: 1};
            return a
        }, t.prototype.drawGradientArc = function (m, d, h, u, t, e, c, i, a, r, s, g) {
            var n, f, o, y, l, p, b, v, x, w, E, T, k, I, C, M, N, L, H, S;
            if (r && this.drawArc(m, d, h, u, t, e, c, "transparent", r, s, g), g || (1 === e ? t = 1 - e : e = 1 - e), w = this.hexToRgb(i), x = this.hexToRgb(a), T = this.hexToRgb(this.getColorBetween(w, x, t)), I = this.hexToRgb(this.getColorBetween(w, x, e)), b = Math.ceil(30 * Math.abs(e - t)), y = this.getGradientColors(T, I, b), n = -.5 * Math.PI + 2 * Math.PI * t, l = y.length, f = g ? (k = 2 * Math.PI * (e - t) / l, 1) : (k = -2 * Math.PI * (e + t) / l, -1), E = function (t, e, i) {
                var a, r, s, n, o, l, p;
                return r = y[t], s = y[t + 1] || r, n = d + Math.cos(e) * u, l = d + Math.cos(e + k) * u, o = h + Math.sin(e) * u, p = h + Math.sin(e + k) * u, m.beginPath(), (a = m.createLinearGradient(n, o, l, p)).addColorStop(0, r), a.addColorStop(1, s), m.lineCap = i, m.strokeStyle = a, m.arc(d, h, u, e - .005 * f, e + k + .005 * f, !g), m.lineWidth = c, m.stroke(), m.closePath()
            }, l) {
                if (o = n + k * (l - 1), 1 < l) {
                    for (p = M = 0, L = (v = Math.ceil(l / 2)) - 1; 0 <= L ? M <= L : L <= M; p = 0 <= L ? ++M : --M) 0 === p && (C = k, k *= .01, E(p, n, s), k = C), E(p, n, "butt"), n += k;
                    for (n = o, S = [], p = N = H = l - 1; H <= v ? N <= v : v <= N; p = H <= v ? ++N : --N) p === l - 1 && (C = k, k *= .01, E(p, n + .99 * C, s), k = C), E(p, n, "butt"), S.push(n -= k);
                    return S
                }
                if (1 === l) return E(0, n, s)
            }
        }, t.prototype.drawArc = function (t, e, i, a, r, s, n, o, l, p, m) {
            if (r <= s) return "string" != typeof o ? this.drawGradientArc(t, e, i, a, r, s, n, o[0], o[1], l, p, m) : (t.beginPath(), t.lineWidth = n, t.strokeStyle = "transparent" === o || "opacity" === o ? "rgba(0,0,0,0)" : o, t.arc(e, i, a, -.5 * Math.PI + 2 * Math.PI * r, -.5 * Math.PI + 2 * Math.PI * s, !m), t.lineCap = p, t.stroke())
        }, t.prototype.drawRing = function (t, e, i, a, r, s, n, o, l, p, m, d, h, u, c) {
            var g, f, y, b, v, x, w;
            if ((y = 1) < y + 0 && (y -= -1 + y + 0, r += 0), f = (v = r) + y, g = r + ((b = a * y) - 0 * (w = .5 - Math.abs(-.5 + a))), x = r + (b + 0 * (1 - w)), s || p) return this.drawArc(t, e, i, s, x, f, n, o, l, u, c), this.drawArc(t, e, i, p, v, g, m, d, h, u, c)
        }, t.prototype.circleTick = function () {
            var t, e, i, a, r, s, n, o, l, p, m, d;
            for (p in m = parseInt(this.params.design.params.width), o = parseInt(this.params.design.params.radius) + Math.round(m / 2), 0, "round", s = this.params.design.params["line-color"], l = this.params.design.params["background-color"], null, r = "direct" === this.params.design.params.direction, d = [], this.timerElements) this.timerElements[p].view && this.timerElements[p].updated && null != (t = document.getElementById("timer-canvas-" + this.id + "-" + p)) && t.getContext ? ((a = t.getContext("2d")).clearRect(0, 0, t.width, t.height), e = Math.round(t.width / 2), i = Math.round(t.height / 2), n = this.timerElements[p].value / this.timerElements[p].max, r && (n = 1 - n), d.push(this.drawRing(a, e, i, n, 0, o, m, l, null, o, m, s, null, "round", r))) : d.push(void 0);
            return d
        }, t.prototype.plateTick = function () {
            var a, r, s, n, t, o, l, p, m, e, d;
            for (o in l = function (t, e) {
                var i, a, r;
                if (d.animationSupport() && d.params.design.params.animation) return r = d.params.design.params.effect, i = document.getElementById("timer-number-" + r + t + "-" + d.id + "-" + e), d.removeClass(i, "timer-" + r + "-animate"), a = d, requestAnimationFrame(function () {
                    return i.offsetLeft, a.addClass(i, "timer-" + r + "-animate")
                })
            }, e = [], (d = this).timerElements) this.timerElements[o].updated ? (t = this.timerElements[o].value, m = [t % 10, Math.floor(t / 10 % 10), Math.floor(t / 100)], r = 0, e.push(function () {
                var t, e, i;
                for (i = [], t = 0, e = m.length; t < e; t++) {
                    switch (p = m[t], this.params.design.params.effect) {
                        case"flipchart":
                            null != (n = document.getElementById("timer-number-flipchart" + r + "-" + this.id + "-" + o)) && null != n.childNodes && 1 === n.childNodes.length && (a = n.childNodes[0].childNodes) && null != a && 5 === a.length && a[0].innerHTML !== p && (s = parseInt(a[1].innerHTML), !1, null != s && 0 <= s && s <= 9 || (!0, s = ""), this.params.design.params.animation || (s = p), s === p && this.params.design.params.animation || (a[0].innerHTML = s, a[1].innerHTML = p, a[2].innerHTML = p, a[3].innerHTML = s, l(r, o)));
                            break;
                        case"slide":
                            null != (n = document.getElementById("timer-number-slide" + r + "-" + this.id + "-" + o)) && null != n.childNodes && 3 === n.childNodes.length && (a = n.childNodes) && a[1].innerHTML !== p && (s = parseInt(a[1].innerHTML), !1, null != s && 0 <= s && s <= 9 || (!0, s = ""), this.params.design.params.animation || (s = p), s === p && this.params.design.params.animation || (a[0].innerHTML = s, a[1].innerHTML = p, l(r, o)))
                    }
                    i.push(r++)
                }
                return i
            }.call(this))) : e.push(void 0);
            return e
        }, t.prototype.getCookie = function (t) {
            var e;
            return (e = document.cookie.match(new RegExp("(?:^|; )" + t.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") + "=([^;]*)"))) ? decodeURIComponent(e[1]) : null
        }, t.prototype.setCookie = function (t, e, i) {
            var a = (i = i || {}).expires;
            if ("number" == typeof a && a) {
                var r = new Date;
                r.setTime(r.getTime() + 1e3 * a), a = i.expires = r
            }
            a && a.toUTCString && (i.expires = a.toUTCString());
            var s = t + "=" + (e = encodeURIComponent(e));
            for (var n in i) {
                s += "; " + n;
                var o = i[n];
                !0 !== o && (s += "=" + o)
            }
            return document.cookie = s
        }, t.prototype.cloneObject = function (t) {
            var e, i, a;
            if (!t || "object" != typeof t) return t;
            for (i in e = "function" == typeof t.pop ? [] : {}, t) o.call(t, i) && (a = t[i], e[i] = a && "object" == typeof a ? this.cloneObject(a) : a);
            return e
        }, r = function (t, e, i, a) {
            return null == a && (a = !1), null != t.addEventListener ? t.addEventListener(e, i, a) : null != t.attachEvent ? t.attachEvent("on" + e, i) : t["on" + e] = function () {
                return i()
            }
        }, t.prototype.addCustomCss = function (t) {
            var e, i;
            return a = "timer-" + this.id + "-style", null != (i = document.getElementById(a)) && (i.styleSheet ? i.styleSheet.cssText = "" : i.innerHTML = "", i.parentNode.removeChild(i)), e = document.getElementsByTagName("head")[0], (i = document.createElement("style")).setAttribute("type", "text/css"), i.id = a, i.styleSheet ? i.styleSheet.cssText = t : i.appendChild(document.createTextNode(t)), e.appendChild(i)
        }, t.prototype.addCssLink = function (t) {
            var e, i, a, r, s, n, o;
            if (null != t && ((i = document.createElement("div")).innerHTML = t, null != (a = document.getElementsByTagName("head")) && 0 < a.length && i.childNodes.length)) {
                for (e = i.childNodes[0], n = (o = a[s = 0].childNodes).length; s < n; s++) if (r = o[s], this.isEqualsNodes(r, e)) return;
                return a[0].appendChild(e)
            }
        }, t.prototype.isEqualsNodes = function (t, e) {
            var i, a, r, s, n, o, l, p, m;
            if (null != t && null != e) if ("#text" === t.nodeName || "#text" === e.nodeName) {
                if ("#text" === t.nodeName && "#text" === e.nodeName && t.data === e.data) return !0
            } else if (null != t.tagName && null != e.tagName && t.tagName.toLowerCase() === e.tagName.toLowerCase()) {
                for (a = 0, s = (o = t.attributes).length; a < s; a++) {
                    if (l = !(i = o[a]), 0 <= u.call(e.attributes, l)) return !1;
                    if (i.value !== e.getAttribute(i.nodeName)) return !1
                }
                for (r = 0, n = (p = e.attributes).length; r < n; r++) {
                    if (m = !(i = p[r]), 0 <= u.call(t.attributes, m)) return !1;
                    if (i.value !== t.getAttribute(i.nodeName)) return !1
                }
                return !0
            }
            return !1
        }, t.prototype.addClass = function (t, e) {
            if (!this.hasClass(t, e)) return t.className = "" === t.className ? e : t.className + " " + e
        }, t.prototype.removeClass = function (t, e) {
            var i;
            return i = new RegExp("(?:^|\\s)" + e + "(?!\\S)", "g"), t.className = t.className.replace(i, "")
        }, t.prototype.hasClass = function (t, e) {
            return null != t.className && -1 !== t.className.indexOf(e)
        }, t.prototype.animationSupport = function () {
            var t, e, i, a, r, s, n, o, l;
            if (null != window.animationSupport) return window.animationSupport;
            if (o = !1, n = ["Webkit", "Moz", "O", "ms", "Khtml"], void 0 !== document.body.style.animationName && (o = !0), !o) for (s = 0; s < n.length;) {
                if (void 0 !== document.body.style[n[s] + "AnimationName"]) {
                    o = !0;
                    break
                }
                s++
            }
            if (o) {
                for (a = document.createElement("div"), i = ["-webkit-", "-moz-", "-ms-", ""], e = "", s = 0; s < i.length;) e += "@" + i[s] + "keyframes csspseudoanimations { from { font-size: 10px; } }", s++;
                for (e += '#timer-tester:before { content:" "; font-size:5px;', s = 0; s < i.length;) e += i[s] + "animation:csspseudoanimations 1ms infinite;", e += i[s] + "animation-fill-mode: forwards;", s++;
                l = '<style id="s-timer-tester">' + (e += "}") + "</style>", a.id = "timer-tester", a.innerHTML += l, null == (t = document.body) && ((t = document.createElement("body")).fake = !0), t.appendChild(a), null != t.fake && (t.style.background = "", t.style.overflow = "hidden", r = docElement.style.overflow, docElement.style.overflow = "hidden", docElement.appendChild(t)), o = "10px" === window.getComputedStyle(a, ":before").getPropertyValue("font-size"), null != t.fake ? (t.parentNode.removeChild(t), docElement.style.overflow = r, docElement.offsetHeight) : a.parentNode.removeChild(a)
            }
            return window.animationSupport = o
        }, t.prototype.getIEVersion = function () {
            var t, e;
            return null != (t = window.navigator.userAgent.match(/MSIE *\d+\.\w+/i)) && 1 < (e = t[0].split(/[ \/\.]/i)).length ? parseInt(e[1]) : null
        }, t
    }()
}).call(this);