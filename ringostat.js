!function () {
    "use strict";
    var objectProto = Object.prototype, hasOwnProperty = objectProto.hasOwnProperty;

    function baseHas(e, t) {
        return null != e && hasOwnProperty.call(e, t)
    }

    var _baseHas = baseHas, isArray = Array.isArray, isArray_1 = isArray,
        commonjsGlobal = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : {};

    function createCommonjsModule(e, t) {
        return e(t = {exports: {}}, t.exports), t.exports
    }

    var freeGlobal = "object" == typeof commonjsGlobal && commonjsGlobal && commonjsGlobal.Object === Object && commonjsGlobal,
        _freeGlobal = freeGlobal, freeSelf = "object" == typeof self && self && self.Object === Object && self,
        root = _freeGlobal || freeSelf || Function("return this")(), _root = root, Symbol$1 = _root.Symbol,
        _Symbol = Symbol$1, objectProto$1 = Object.prototype, hasOwnProperty$1 = objectProto$1.hasOwnProperty,
        nativeObjectToString = objectProto$1.toString, symToStringTag = _Symbol ? _Symbol.toStringTag : void 0;

    function getRawTag(e) {
        var t = hasOwnProperty$1.call(e, symToStringTag), a = e[symToStringTag];
        try {
            e[symToStringTag] = void 0;
            var n = !0
        } catch (e) {
        }
        var r = nativeObjectToString.call(e);
        return n && (t ? e[symToStringTag] = a : delete e[symToStringTag]), r
    }

    var _getRawTag = getRawTag, objectProto$2 = Object.prototype, nativeObjectToString$1 = objectProto$2.toString;

    function objectToString(e) {
        return nativeObjectToString$1.call(e)
    }

    var _objectToString = objectToString, nullTag = "[object Null]", undefinedTag = "[object Undefined]",
        symToStringTag$1 = _Symbol ? _Symbol.toStringTag : void 0;

    function baseGetTag(e) {
        return null == e ? void 0 === e ? undefinedTag : nullTag : symToStringTag$1 && symToStringTag$1 in Object(e) ? _getRawTag(e) : _objectToString(e)
    }

    var _baseGetTag = baseGetTag;

    function isObjectLike(e) {
        return null != e && "object" == typeof e
    }

    var isObjectLike_1 = isObjectLike, symbolTag = "[object Symbol]";

    function isSymbol(e) {
        return "symbol" == typeof e || isObjectLike_1(e) && _baseGetTag(e) == symbolTag
    }

    var isSymbol_1 = isSymbol, reIsDeepProp = /\.|\[(?:[^[\]]*|(["'])(?:(?!\1)[^\\]|\\.)*?\1)\]/,
        reIsPlainProp = /^\w*$/;

    function isKey(e, t) {
        if (isArray_1(e)) return !1;
        var a = typeof e;
        return !("number" != a && "symbol" != a && "boolean" != a && null != e && !isSymbol_1(e)) || (reIsPlainProp.test(e) || !reIsDeepProp.test(e) || null != t && e in Object(t))
    }

    var _isKey = isKey;

    function isObject(e) {
        var t = typeof e;
        return null != e && ("object" == t || "function" == t)
    }

    var isObject_1 = isObject, asyncTag = "[object AsyncFunction]", funcTag = "[object Function]",
        genTag = "[object GeneratorFunction]", proxyTag = "[object Proxy]";

    function isFunction(e) {
        if (!isObject_1(e)) return !1;
        var t = _baseGetTag(e);
        return t == funcTag || t == genTag || t == asyncTag || t == proxyTag
    }

    var isFunction_1 = isFunction, coreJsData = _root["__core-js_shared__"], _coreJsData = coreJsData,
        maskSrcKey = (uid = /[^.]+$/.exec(_coreJsData && _coreJsData.keys && _coreJsData.keys.IE_PROTO || ""), uid ? "Symbol(src)_1." + uid : ""),
        uid;

    function isMasked(e) {
        return !!maskSrcKey && maskSrcKey in e
    }

    var _isMasked = isMasked, funcProto = Function.prototype, funcToString = funcProto.toString;

    function toSource(e) {
        if (null != e) {
            try {
                return funcToString.call(e)
            } catch (e) {
            }
            try {
                return e + ""
            } catch (e) {
            }
        }
        return ""
    }

    var _toSource = toSource, reRegExpChar = /[\\^$.*+?()[\]{}|]/g, reIsHostCtor = /^\[object .+?Constructor\]$/,
        funcProto$1 = Function.prototype, objectProto$3 = Object.prototype, funcToString$1 = funcProto$1.toString,
        hasOwnProperty$2 = objectProto$3.hasOwnProperty,
        reIsNative = RegExp("^" + funcToString$1.call(hasOwnProperty$2).replace(reRegExpChar, "\\$&").replace(/hasOwnProperty|(function).*?(?=\\\()| for .+?(?=\\\])/g, "$1.*?") + "$");

    function baseIsNative(e) {
        return !(!isObject_1(e) || _isMasked(e)) && (isFunction_1(e) ? reIsNative : reIsHostCtor).test(_toSource(e))
    }

    var _baseIsNative = baseIsNative;

    function getValue(e, t) {
        return null == e ? void 0 : e[t]
    }

    var _getValue = getValue;

    function getNative(e, t) {
        var a = _getValue(e, t);
        return _baseIsNative(a) ? a : void 0
    }

    var _getNative = getNative, nativeCreate = _getNative(Object, "create"), _nativeCreate = nativeCreate;

    function hashClear() {
        this.__data__ = _nativeCreate ? _nativeCreate(null) : {}, this.size = 0
    }

    var _hashClear = hashClear;

    function hashDelete(e) {
        var t = this.has(e) && delete this.__data__[e];
        return this.size -= t ? 1 : 0, t
    }

    var _hashDelete = hashDelete, HASH_UNDEFINED = "__lodash_hash_undefined__", objectProto$4 = Object.prototype,
        hasOwnProperty$3 = objectProto$4.hasOwnProperty;

    function hashGet(e) {
        var t = this.__data__;
        if (_nativeCreate) {
            var a = t[e];
            return a === HASH_UNDEFINED ? void 0 : a
        }
        return hasOwnProperty$3.call(t, e) ? t[e] : void 0
    }

    var _hashGet = hashGet, objectProto$5 = Object.prototype, hasOwnProperty$4 = objectProto$5.hasOwnProperty;

    function hashHas(e) {
        var t = this.__data__;
        return _nativeCreate ? void 0 !== t[e] : hasOwnProperty$4.call(t, e)
    }

    var _hashHas = hashHas, HASH_UNDEFINED$1 = "__lodash_hash_undefined__";

    function hashSet(e, t) {
        var a = this.__data__;
        return this.size += this.has(e) ? 0 : 1, a[e] = _nativeCreate && void 0 === t ? HASH_UNDEFINED$1 : t, this
    }

    var _hashSet = hashSet;

    function Hash(e) {
        var t = -1, a = null == e ? 0 : e.length;
        for (this.clear(); ++t < a;) {
            var n = e[t];
            this.set(n[0], n[1])
        }
    }

    Hash.prototype.clear = _hashClear, Hash.prototype.delete = _hashDelete, Hash.prototype.get = _hashGet, Hash.prototype.has = _hashHas, Hash.prototype.set = _hashSet;
    var _Hash = Hash;

    function listCacheClear() {
        this.__data__ = [], this.size = 0
    }

    var _listCacheClear = listCacheClear;

    function eq(e, t) {
        return e === t || e != e && t != t
    }

    var eq_1 = eq;

    function assocIndexOf(e, t) {
        for (var a = e.length; a--;) if (eq_1(e[a][0], t)) return a;
        return -1
    }

    var _assocIndexOf = assocIndexOf, arrayProto = Array.prototype, splice = arrayProto.splice;

    function listCacheDelete(e) {
        var t = this.__data__, a = _assocIndexOf(t, e);
        return !(a < 0) && (a == t.length - 1 ? t.pop() : splice.call(t, a, 1), --this.size, !0)
    }

    var _listCacheDelete = listCacheDelete;

    function listCacheGet(e) {
        var t = this.__data__, a = _assocIndexOf(t, e);
        return a < 0 ? void 0 : t[a][1]
    }

    var _listCacheGet = listCacheGet;

    function listCacheHas(e) {
        return _assocIndexOf(this.__data__, e) > -1
    }

    var _listCacheHas = listCacheHas;

    function listCacheSet(e, t) {
        var a = this.__data__, n = _assocIndexOf(a, e);
        return n < 0 ? (++this.size, a.push([e, t])) : a[n][1] = t, this
    }

    var _listCacheSet = listCacheSet;

    function ListCache(e) {
        var t = -1, a = null == e ? 0 : e.length;
        for (this.clear(); ++t < a;) {
            var n = e[t];
            this.set(n[0], n[1])
        }
    }

    ListCache.prototype.clear = _listCacheClear, ListCache.prototype.delete = _listCacheDelete, ListCache.prototype.get = _listCacheGet, ListCache.prototype.has = _listCacheHas, ListCache.prototype.set = _listCacheSet;
    var _ListCache = ListCache, Map$1 = _getNative(_root, "Map"), _Map = Map$1;

    function mapCacheClear() {
        this.size = 0, this.__data__ = {hash: new _Hash, map: new (_Map || _ListCache), string: new _Hash}
    }

    var _mapCacheClear = mapCacheClear;

    function isKeyable(e) {
        var t = typeof e;
        return "string" == t || "number" == t || "symbol" == t || "boolean" == t ? "__proto__" !== e : null === e
    }

    var _isKeyable = isKeyable;

    function getMapData(e, t) {
        var a = e.__data__;
        return _isKeyable(t) ? a["string" == typeof t ? "string" : "hash"] : a.map
    }

    var _getMapData = getMapData;

    function mapCacheDelete(e) {
        var t = _getMapData(this, e).delete(e);
        return this.size -= t ? 1 : 0, t
    }

    var _mapCacheDelete = mapCacheDelete;

    function mapCacheGet(e) {
        return _getMapData(this, e).get(e)
    }

    var _mapCacheGet = mapCacheGet;

    function mapCacheHas(e) {
        return _getMapData(this, e).has(e)
    }

    var _mapCacheHas = mapCacheHas;

    function mapCacheSet(e, t) {
        var a = _getMapData(this, e), n = a.size;
        return a.set(e, t), this.size += a.size == n ? 0 : 1, this
    }

    var _mapCacheSet = mapCacheSet;

    function MapCache(e) {
        var t = -1, a = null == e ? 0 : e.length;
        for (this.clear(); ++t < a;) {
            var n = e[t];
            this.set(n[0], n[1])
        }
    }

    MapCache.prototype.clear = _mapCacheClear, MapCache.prototype.delete = _mapCacheDelete, MapCache.prototype.get = _mapCacheGet, MapCache.prototype.has = _mapCacheHas, MapCache.prototype.set = _mapCacheSet;
    var _MapCache = MapCache, FUNC_ERROR_TEXT = "Expected a function";

    function memoize(e, t) {
        if ("function" != typeof e || null != t && "function" != typeof t) throw new TypeError(FUNC_ERROR_TEXT);
        var a = function () {
            var n = arguments, r = t ? t.apply(this, n) : n[0], o = a.cache;
            if (o.has(r)) return o.get(r);
            var i = e.apply(this, n);
            return a.cache = o.set(r, i) || o, i
        };
        return a.cache = new (memoize.Cache || _MapCache), a
    }

    memoize.Cache = _MapCache;
    var memoize_1 = memoize, MAX_MEMOIZE_SIZE = 500;

    function memoizeCapped(e) {
        var t = memoize_1(e, function (e) {
            return a.size === MAX_MEMOIZE_SIZE && a.clear(), e
        }), a = t.cache;
        return t
    }

    var _memoizeCapped = memoizeCapped,
        rePropName = /[^.[\]]+|\[(?:(-?\d+(?:\.\d+)?)|(["'])((?:(?!\2)[^\\]|\\.)*?)\2)\]|(?=(?:\.|\[\])(?:\.|\[\]|$))/g,
        reEscapeChar = /\\(\\)?/g, stringToPath = _memoizeCapped(function (e) {
            var t = [];
            return 46 === e.charCodeAt(0) && t.push(""), e.replace(rePropName, function (e, a, n, r) {
                t.push(n ? r.replace(reEscapeChar, "$1") : a || e)
            }), t
        }), _stringToPath = stringToPath;

    function arrayMap(e, t) {
        for (var a = -1, n = null == e ? 0 : e.length, r = Array(n); ++a < n;) r[a] = t(e[a], a, e);
        return r
    }

    var _arrayMap = arrayMap, INFINITY = 1 / 0, symbolProto = _Symbol ? _Symbol.prototype : void 0,
        symbolToString = symbolProto ? symbolProto.toString : void 0;

    function baseToString(e) {
        if ("string" == typeof e) return e;
        if (isArray_1(e)) return _arrayMap(e, baseToString) + "";
        if (isSymbol_1(e)) return symbolToString ? symbolToString.call(e) : "";
        var t = e + "";
        return "0" == t && 1 / e == -INFINITY ? "-0" : t
    }

    var _baseToString = baseToString;

    function toString(e) {
        return null == e ? "" : _baseToString(e)
    }

    var toString_1 = toString;

    function castPath(e, t) {
        return isArray_1(e) ? e : _isKey(e, t) ? [e] : _stringToPath(toString_1(e))
    }

    var _castPath = castPath, argsTag = "[object Arguments]";

    function baseIsArguments(e) {
        return isObjectLike_1(e) && _baseGetTag(e) == argsTag
    }

    var _baseIsArguments = baseIsArguments, objectProto$6 = Object.prototype,
        hasOwnProperty$5 = objectProto$6.hasOwnProperty, propertyIsEnumerable = objectProto$6.propertyIsEnumerable,
        isArguments = _baseIsArguments(function () {
            return arguments
        }()) ? _baseIsArguments : function (e) {
            return isObjectLike_1(e) && hasOwnProperty$5.call(e, "callee") && !propertyIsEnumerable.call(e, "callee")
        }, isArguments_1 = isArguments, MAX_SAFE_INTEGER = 9007199254740991, reIsUint = /^(?:0|[1-9]\d*)$/;

    function isIndex(e, t) {
        var a = typeof e;
        return !!(t = null == t ? MAX_SAFE_INTEGER : t) && ("number" == a || "symbol" != a && reIsUint.test(e)) && e > -1 && e % 1 == 0 && e < t
    }

    var _isIndex = isIndex, MAX_SAFE_INTEGER$1 = 9007199254740991;

    function isLength(e) {
        return "number" == typeof e && e > -1 && e % 1 == 0 && e <= MAX_SAFE_INTEGER$1
    }

    var isLength_1 = isLength, INFINITY$1 = 1 / 0;

    function toKey(e) {
        if ("string" == typeof e || isSymbol_1(e)) return e;
        var t = e + "";
        return "0" == t && 1 / e == -INFINITY$1 ? "-0" : t
    }

    var _toKey = toKey;

    function hasPath(e, t, a) {
        for (var n = -1, r = (t = _castPath(t, e)).length, o = !1; ++n < r;) {
            var i = _toKey(t[n]);
            if (!(o = null != e && a(e, i))) break;
            e = e[i]
        }
        return o || ++n != r ? o : !!(r = null == e ? 0 : e.length) && isLength_1(r) && _isIndex(i, r) && (isArray_1(e) || isArguments_1(e))
    }

    var _hasPath = hasPath;

    function has(e, t) {
        return null != e && _hasPath(e, t, _baseHas)
    }

    var has_1 = has;

    function isUndefined(e) {
        return void 0 === e
    }

    var isUndefined_1 = isUndefined, config = {
        "ringostatProjectHash": "879dd20e1f58ab1e9980f5c3d3f690af942c4f62",
        "uaId": "UA-110788820-1",
        "classified": 0,
        "xpaths": [{
            "xPath": "\/\/div[@class='icon-top-bar']\/a[contains(.,'777 540 99 27')]",
            "onlyForRegion": "",
            "mask": "+# ### ### ## ##",
            "checkOnClient": "0",
            "callMeAll": "0",
            "reservedNumbersPercent": "0",
            "callMeMobile": "0",
            "geoGroup": "1",
            "callMeHTML": ""
        }, {
            "xPath": "\/\/div[@class='item-description']\/\/div\/ul[.\/li[contains(.,'777 540 99 27')]]",
            "onlyForRegion": "",
            "mask": "<li itemprop=\"address\"itemtype=\"http:\/\/schema.org\/PostalAddress\"><span >\u0410\u0434\u0440\u0435\u0441: \u0433. <span itemprop=\"addressLocality\">\u041a\u0430\u0440\u0430\u0433\u0430\u043d\u0434\u0430, \u041a\u0430\u0437\u0430\u0445\u0441\u0442\u0430\u043d<\/span>, <span itemprop=\"streetAddress\">\u0421\u043a\u043b\u0430\u0434\u0441\u043a\u0430\u044f 2 \u043a.1<\/span><\/span><\/li> \t<li><span>\u0420\u0435\u0436\u0438\u043c \u0440\u0430\u0431\u043e\u0442\u044b: \u041f\u041d-\u041f\u0422 \u0441 09.00 \u0434\u043e 18.00<\/span><\/li> \t<li><span>\u0411\u0435\u0437 \u043e\u0431\u0435\u0434\u0435\u043d\u043d\u043e\u0433\u043e \u043f\u0435\u0440\u0435\u0440\u044b\u0432\u0430<\/span><\/li> \t<li>Email: <span itemprop=\"email\">info@sanmarket.kz<\/span><\/li> \t<li><span>\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u043d\u044b\u0435 \u043d\u043e\u043c\u0435\u0440\u0430:<\/span><\/li> \t \t<li><span itemprop=\"telephone\" >+# ### ### ## ##<\/span>",
            "checkOnClient": "0",
            "callMeAll": "0",
            "reservedNumbersPercent": "0",
            "callMeMobile": "0",
            "geoGroup": "1",
            "callMeHTML": ""
        }, {
            "xPath": "\/\/div[@class='header-icon']\/a[@href=\"tel:+77775409927\"]",
            "onlyForRegion": "",
            "mask": "<img class=\"img-icon \" src=\"\/templates\/basic_free\/images\/top\/PHONE.png\" alt=\"phone\"><span class=\"#\"><\/span>",
            "checkOnClient": "0",
            "callMeAll": "0",
            "reservedNumbersPercent": "0",
            "callMeMobile": "0",
            "geoGroup": "1",
            "callMeHTML": ""
        }],
        "isAdvanced": 1,
        "userSettings": {
            "observeDOM": true,
            "browserGeolocation": false,
            "callbackSettings": {
                "delay": false,
                "CallbackOff": false,
                "autoFormOff": false,
                "hideCallbackButton": false
            },
            "customFormDataTracking": {
                "fieldsBlackList": [],
                "isActive": true,
                "pagesBlackList": [],
                "pagesWhiteList": [],
                "phoneInputName": ["phonecallback"],
                "startCallbackOnSubmitForm": true,
                "callbackDuringBusinessHours": true
            },
            "callback": "function (data) {}",
            "messengers": {
                "telegram": {"bot_name": "Sanmarket_Bot", "enabled": 0, "bot_id": ""},
                "viber": {"bot_name": "sanmarket", "enabled": 0, "bot_id": ""},
                "facebookMessenger": {"bot_name": "SanMarket.kz", "enabled": 0, "bot_id": "110702453979789"}
            }
        },
        "substitutionStatus": 1,
        "crossDomainTracking": 0,
        "trackedEntities": {
            "metrikaClientId": {
                "level": "session",
                "type": "expression",
                "value": "yaCounter51363598.getClientID()"
            }
        },
        "userFormsSettings": {"connectIntlTelInputPlugin": false, "forms": []}
    }, urls = {
        changedNumber: "https://analytics.ringostat.net/changed_number/",
        collect: "https://analytics.ringostat.net/collect/",
        ping: "https://analytics.ringostat.net/ping/",
        backend: "https://app.ringostat.com/",
        api: "https://api.ringostat.com/",
        analytics: "https://analytics.ringostat.net/",
        apiV2: "https://analytics.ringostat.net/api_v2?token=27a69aed645097ff7b46aead77ef0ad8",
        substitution: "https://substitution.ringostat.net/"
    }, createFunction = function (e, t) {
        return "string" == typeof e && 0 === e.indexOf("function") ? new Function("return ".concat(e))() : t
    };
    config.urls = urls, config.userSettings = config.userSettings || {}, config.manualMode = config.userSettings.manualMode || !1, config.browserGeolocation = void 0 === config.userSettings.browserGeolocation || config.userSettings.browserGeolocation, config.callbackSettings = config.userSettings.callbackSettings || {}, config.changedNumberCallback = createFunction(config.userSettings.callback, function () {
    }), config.cookieDomain = config.userSettings.cookieDomain || "", config.cookies = {
        rngst1: "rngst1",
        rngst2: "rngst2"
    }, config.ga = config.userSettings.GoogleAnalyticsObject ? config.userSettings.GoogleAnalyticsObject : window.GoogleAnalyticsObject, config.interactionEvents = ["mousedown", "mouseup", "mousemove", "onscroll", "touchstart", "touchmove", "touchend", "keydown", "keyup"], config.isAdvanced = config.isAdvanced || !1, config.numbersData = [], config.observeDOM = config.userSettings.observeDOM || !1, config.pingInterval = 15e3, config.phoneNumber = config.phoneNumber || null, config.roistatTracking = config.userSettings.roistatTracking || !1, config.sessionLength = config.userSettings.sessionLength || 300, config.sessionLengthMS = 1e3 * config.sessionLength, 0 !== config.substitutionStatus ? config.substitutionEnabled = createFunction(config.userSettings.initChangeNumber, function () {
        return !0
    })() : config.substitutionEnabled = 0, config.trackedEntities = config.trackedEntities || {}, config.ringostatRecaptchaKey = "6LeIw_0UAAAAAGEDTrNitDr_4BTLmnHqro3TVo0f";
    for (var rngBrowser = createCommonjsModule(function (e) {
        var t = "undefined" != typeof crypto && crypto.getRandomValues.bind(crypto) || "undefined" != typeof msCrypto && msCrypto.getRandomValues.bind(msCrypto);
        if (t) {
            var a = new Uint8Array(16);
            e.exports = function () {
                return t(a), a
            }
        } else {
            var n = new Array(16);
            e.exports = function () {
                for (var e, t = 0; t < 16; t++) 0 == (3 & t) && (e = 4294967296 * Math.random()), n[t] = e >>> ((3 & t) << 3) & 255;
                return n
            }
        }
    }), byteToHex = [], i = 0; i < 256; ++i) byteToHex[i] = (i + 256).toString(16).substr(1);

    function bytesToUuid(e, t) {
        var a = t || 0, n = byteToHex;
        return n[e[a++]] + n[e[a++]] + n[e[a++]] + n[e[a++]] + "-" + n[e[a++]] + n[e[a++]] + "-" + n[e[a++]] + n[e[a++]] + "-" + n[e[a++]] + n[e[a++]] + "-" + n[e[a++]] + n[e[a++]] + n[e[a++]] + n[e[a++]] + n[e[a++]] + n[e[a++]]
    }

    var bytesToUuid_1 = bytesToUuid;

    function v4(e, t, a) {
        var n = t && a || 0;
        "string" == typeof e && (t = "binary" === e ? new Array(16) : null, e = null);
        var r = (e = e || {}).random || (e.rng || rngBrowser)();
        if (r[6] = 15 & r[6] | 64, r[8] = 63 & r[8] | 128, t) for (var o = 0; o < 16; ++o) t[n + o] = r[o];
        return t || bytesToUuid_1(r)
    }

    var v4_1 = v4, createCookie = function (e, t, a, n) {
        document.cookie = "".concat(e, "=").concat(encodeURIComponent(JSON.stringify(t)), "; expires=").concat(new Date((new Date).getTime() + 1e3 * a).toUTCString(), "; path=/").concat(n ? "; domain=".concat(n) : "")
    }, eraseCookie = function (e, t) {
        createCookie(e, "", -1, t)
    }, readCookie = function (e, t) {
        var a = document.cookie.match(new RegExp("(^|;)\\s*".concat(e, "\\s*=\\s*([^;]+)")));
        return a = a ? decodeURIComponent(a.pop()) : null, t ? JSON.parse(a) : a
    }, refreshCookie = function (e, t, a) {
        createCookie(e, readCookie(e, !0), t, a)
    }, findGaTracker = function (e, t) {
        if (!0 !== config.userSettings.noGa) {
            if (void 0 === e[t]) return null;
            if ("function" != typeof e[t].getAll) return null;
            var a = e[t].getAll();
            if (!1 === Array.isArray(a) || 0 === a.length) return null;
            for (var n = a.length, r = 0; r < n; r += 1) {
                var o = a[r];
                if (o.get("ringostatTracker")) return o
            }
            return null
        }
        var i = readCookie("rngst", "clientId") ? readCookie("rngst", !0).clientId : v4_1();
        return createCookie("rngst", {clientId: i}, 31536e3, config.cookieDomain), {
            clientId: i,
            trackingId: config.uaId
        }
    }, computeChangeNumberParams = function (e) {
        var t = e.clientId, a = e.cookie, n = e.firstRequest, r = e.forceNumber, o = e.geoLocation, i = e.pageViewId,
            s = e.projectHash, c = e.adId, u = e.xPathId, M = e.sl, g = "";
        return g += "r_h=".concat(encodeURIComponent(s)), g += "&r_cl=".concat(encodeURIComponent(t)), g += "&r_cu=".concat(encodeURIComponent(window.location.href)), g += "&r_re=".concat(encodeURIComponent(document.referrer)), g += "&r_ce=".concat(encodeURIComponent(a)), g += "&r_ur=".concat(n), g += "&r_us=".concat(encodeURIComponent(window.navigator.userAgent)), g += "&r_fs=".concat(null), g += "&r_fn=".concat(r ? "forceNumber" : null), g += "&dt=".concat(encodeURIComponent(document.title)), g += "&hid=".concat(i), g += "&vid=".concat(i), o.latitude && (g += "&r_la=".concat(encodeURIComponent(o.latitude))), o.longitude && (g += "&r_lo=".concat(encodeURIComponent(o.longitude))), o.accuracy && (g += "&r_a=".concat(encodeURIComponent(o.accuracy))), o.city && (g += "&r_ci=".concat(encodeURIComponent(o.city))), o.country && (g += "&r_cy=".concat(encodeURIComponent(o.country))), c && (g += "&r_ai=".concat(encodeURIComponent(c))), u && (g += "&r_x=".concat(encodeURIComponent(u))), M && (g += "&sl=".concat(M)), g
    }, nativeFloor = Math.floor, nativeRandom = Math.random;

    function baseRandom(e, t) {
        return e + nativeFloor(nativeRandom() * (t - e + 1))
    }

    var _baseRandom = baseRandom;

    function isArrayLike(e) {
        return null != e && isLength_1(e.length) && !isFunction_1(e)
    }

    var isArrayLike_1 = isArrayLike;

    function isIterateeCall(e, t, a) {
        if (!isObject_1(a)) return !1;
        var n = typeof t;
        return !!("number" == n ? isArrayLike_1(a) && _isIndex(t, a.length) : "string" == n && t in a) && eq_1(a[t], e)
    }

    var _isIterateeCall = isIterateeCall, NAN = NaN, reTrim = /^\s+|\s+$/g, reIsBadHex = /^[-+]0x[0-9a-f]+$/i,
        reIsBinary = /^0b[01]+$/i, reIsOctal = /^0o[0-7]+$/i, freeParseInt = parseInt;

    function toNumber(e) {
        if ("number" == typeof e) return e;
        if (isSymbol_1(e)) return NAN;
        if (isObject_1(e)) {
            var t = "function" == typeof e.valueOf ? e.valueOf() : e;
            e = isObject_1(t) ? t + "" : t
        }
        if ("string" != typeof e) return 0 === e ? e : +e;
        e = e.replace(reTrim, "");
        var a = reIsBinary.test(e);
        return a || reIsOctal.test(e) ? freeParseInt(e.slice(2), a ? 2 : 8) : reIsBadHex.test(e) ? NAN : +e
    }

    var toNumber_1 = toNumber, INFINITY$2 = 1 / 0, MAX_INTEGER = 1.7976931348623157e308;

    function toFinite(e) {
        return e ? (e = toNumber_1(e)) === INFINITY$2 || e === -INFINITY$2 ? (e < 0 ? -1 : 1) * MAX_INTEGER : e == e ? e : 0 : 0 === e ? e : 0
    }

    var toFinite_1 = toFinite, freeParseFloat = parseFloat, nativeMin = Math.min, nativeRandom$1 = Math.random;

    function random(e, t, a) {
        if (a && "boolean" != typeof a && _isIterateeCall(e, t, a) && (t = a = void 0), void 0 === a && ("boolean" == typeof t ? (a = t, t = void 0) : "boolean" == typeof e && (a = e, e = void 0)), void 0 === e && void 0 === t ? (e = 0, t = 1) : (e = toFinite_1(e), void 0 === t ? (t = e, e = 0) : t = toFinite_1(t)), e > t) {
            var n = e;
            e = t, t = n
        }
        if (a || e % 1 || t % 1) {
            var r = nativeRandom$1();
            return nativeMin(e + r * (t - e + freeParseFloat("1e-" + ((r + "").length - 1))), t)
        }
        return _baseRandom(e, t)
    }

    var random_1 = random, computePayload = function (e, t, a) {
        return a.jsonRpc && a.method ? {
            method: "POST",
            type: "application/json",
            url: e,
            query: JSON.stringify({jsonrpc: "2.0", method: a.method, params: t, id: random_1(9999)})
        } : t.length <= 2e3 || a.forceGet ? {
            method: "GET",
            type: "text/plain",
            url: "".concat(e, "?").concat(t),
            query: void 0
        } : {method: "POST", type: "application/x-www-form-urlencoded", url: e, query: t}
    }, state = {
        adId: null,
        clientId: "",
        firstRequest: !0,
        geoLocation: {},
        lastInteractionTime: Date.now(),
        lastPayload: "",
        needsRegenerate: !1,
        pageViewId: v4_1(),
        trackingId: "",
        customAdNumber: null
    }, LEVEL_PAGEVIEW = "pageview", LEVEL_SESSION = "session";

    function isNil(e) {
        return null == e
    }

    var isNil_1 = isNil, log = function (e) {
        if ("#debug_ringostat_script" === window.location.hash) return console.log("Ringostat: ".concat(e))
    }, computeAdditionalValue = function computeAdditionalValue(content, type) {
        var manual = arguments.length > 2 && void 0 !== arguments[2] && arguments[2];
        if (manual) return "simple" === type ? content : eval(content);
        try {
            return "simple" === type ? window[content] : eval(content)
        } catch (e) {
            log(e)
        }
        return null
    }, getAdditionalData = function (e, t) {
        var a = {};
        if (void 0 !== window.ringostat_additional_data && t === LEVEL_SESSION) {
            if ("string" == typeof window.ringostat_additional_data) try {
                a = JSON.parse(window.ringostat_additional_data)
            } catch (e) {
                log(e)
            } else "[object Object]" === Object.prototype.toString.call(window.ringostat_additional_data) && (a = window.ringostat_additional_data);
            a.ringostatOldData = 1
        }
        return Object.keys(e).forEach(function (n) {
            var r = e[n], o = r.level, i = r.type, s = r.value;
            if (t === o) {
                var c = computeAdditionalValue(s, i);
                !1 === isNil_1(c) && (a[n] = c)
            }
        }), Object.keys(a).length > 0 ? JSON.stringify(a) : null
    }, computeCollectParams = function (e, t, a) {
        var n = t.clientId, r = t.cookie, o = t.hitId, i = t.firstRequest, s = t.geoLocation, c = t.pageViewId,
            u = t.trackingId, M = '{"adId": "'.concat(a, '"}');
        return ["hid=" + o, "vid=" + c, "r_ad=" + encodeURIComponent(getAdditionalData(e.trackedEntities, LEVEL_SESSION)), "r_ce=" + encodeURIComponent(r), "r_cl=" + encodeURIComponent(n), "r_cu=" + encodeURIComponent(window.location.href), "r_d=" + encodeURIComponent(Date.now()), "r_h=" + encodeURIComponent(e.ringostatProjectHash), "r_pd=" + (!1 === a ? encodeURIComponent(getAdditionalData(e.trackedEntities, LEVEL_PAGEVIEW)) : encodeURIComponent(M)), "r_re=" + encodeURIComponent(document.referrer), "r_ur=" + i, "r_ua=" + encodeURIComponent(u), "r_us=" + encodeURIComponent(window.navigator.userAgent), s.accuracy && "&r_a=" + encodeURIComponent(s.accuracy), s.city && "r_ci=" + encodeURIComponent(s.city), s.country && "r_cy=" + encodeURIComponent(s.country), s.latitude && "r_la=" + encodeURIComponent(s.latitude), s.longitude && "r_lo=" + encodeURIComponent(s.longitude)].filter(Boolean).join("&")
    };

    function noop() {
    }

    var noop_1 = noop, sendPayload = function (e, t) {
        var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {}, n = computePayload(e, t, a),
            r = new ("onload" in new XMLHttpRequest ? XMLHttpRequest : XDomainRequest);
        r.open(n.method, n.url, !0), r.setRequestHeader("Content-Type", n.type), r.onerror = a.onError || noop_1, r.onload = function () {
            a.onSuccess && a.onSuccess(this)
        }, a.withCredentials && (r.withCredentials = !0, r.crossDomain = !0), r.send(n.query), r.onreadystatechange = function () {
            4 === r.readyState && e.indexOf("changed_number") + 1 && ("blackList" === JSON.parse(r.response).msg && console.log("Current IP in block-list: insertion is OFF"))
        }
    }, sendCollect = function (e, t) {
        var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {},
            n = arguments.length > 3 && void 0 !== arguments[3] && arguments[3], r = a.recollect, o = void 0 !== r && r,
            i = "pageview" === e;
        i && (state.needsRegenerate && !1 === o && (state.pageViewId = v4_1()), state.needsRegenerate = !0);
        var s = !1 === i ? v4_1() : state.pageViewId;
        i && (state.lastPayload = t);
        var c = computeCollectParams(config, {
            clientId: state.clientId,
            cookie: readCookie(config.cookies.rngst2, !1),
            firstRequest: state.firstRequest,
            geoLocation: state.geoLocation,
            pageViewId: state.pageViewId,
            trackingId: state.trackingId,
            hitId: s
        }, n);
        state.firstRequest = !1, sendPayload(config.urls.collect, "".concat(t, "&").concat(c))
    }, sendHit = function (e) {
        var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
            a = arguments.length > 2 && void 0 !== arguments[2] && arguments[2], n = t.recollect, r = void 0 !== n && n,
            o = "pageview" === e, i = screen,
            s = ["v=1", "t=" + encodeURIComponent(e), "cid=" + encodeURIComponent(state.clientId), "tid=" + encodeURIComponent(state.trackingId), "dl=" + encodeURIComponent(window.location.href), "dt=" + encodeURIComponent(document.title), "dr=" + encodeURIComponent(document.referrer), "sr=" + encodeURIComponent(i.width + "x" + i.height), "vp=" + encodeURIComponent(i.availWidth + "x" + i.availHeight), "sd=" + encodeURIComponent(i.colorDepth + "-bit"), "a=" + encodeURIComponent(Date.now())].filter(Boolean).join("&");
        o && (state.needsRegenerate && !1 === r && (state.pageViewId = v4_1()), state.needsRegenerate = !0);
        var c = !1 === o ? v4_1() : state.pageViewId;
        o && (state.lastPayload = s);
        var u = computeCollectParams(config, {
            clientId: state.clientId,
            cookie: readCookie(config.cookies.rngst2, !1),
            firstRequest: state.firstRequest,
            geoLocation: state.geoLocation,
            pageViewId: state.pageViewId,
            trackingId: state.trackingId,
            hitId: c
        }, a);
        state.firstRequest = !1, sendPayload(config.urls.collect, "".concat(s, "&").concat(u))
    }, computePingParams = function (e, t) {
        var a = t.clientId, n = t.pageViewId, r = arguments.length > 2 && void 0 !== arguments[2] && arguments[2],
            o = '{"adId": "'.concat(r, '"}');
        return ["hid=" + n, "vid=" + n, "r_ad=" + encodeURIComponent(getAdditionalData(e.trackedEntities, LEVEL_SESSION)), "r_cl=" + encodeURIComponent(a), "r_pd=" + (!1 === r ? encodeURIComponent(getAdditionalData(e.trackedEntities, LEVEL_PAGEVIEW)) : encodeURIComponent(o)), "r_h=" + encodeURIComponent(e.ringostatProjectHash)].join("&")
    }, handleSuccess = function handleSuccess(_ref) {
        var responseText = _ref.responseText, data = JSON.parse(responseText);
        if (void 0 === data.pong) {
            var pingEvents = config.userSettings.dataForPingEvents;
            data.forEach(function (event) {
                var pingEventFn;
                null != event.data && (void 0 !== pingEvents[event.event] && (eval("pingEventFn = " + pingEvents[event.event].cb), pingEventFn(event.data)))
            })
        }
        data.recollect && sendCollect("pageview", state.lastPayload, {recollect: !0})
    }, sendPing = function (e) {
        var t = computePingParams(config, state, e);
        sendPayload(config.urls.ping, t, {forceGet: !0, onSuccess: handleSuccess, withCredentials: !0})
    }, addEvents = function (e, t, a) {
        for (var n = t.length; n--;) e.addEventListener(t[n], a, !1)
    }, maskNumber = function (e, t) {
        var a = -1 !== t.indexOf("+380800") || -1 !== t.indexOf("380800"), n = -1 !== e.indexOf("#"),
            r = -1 !== e.indexOf(t), o = e, i = "".concat(t), s = "+".concat(t);
        if (!0 === a && (-1 !== i.indexOf("+380800") && (i = i.replace("+380", "0")), -1 !== i.indexOf("380800") && (i = i.replace("380", "0"))), !1 === n) return i;
        !0 === n && !0 === a && (-1 !== o.indexOf("+380800") ? (o = e.replace("+" + t, i), o = e.replace("+38", "")) : -1 !== o.indexOf("380800") && (o = e.replace(t, i))), !1 === a && !0 === n && !0 === r && (o = e.replace(t, s));
        for (var c = i.toString().split(""), u = o.toString().split(""), M = c.length; M--;) -1 !== u.lastIndexOf("#") && (u[u.lastIndexOf("#")] = c[+M]);
        var g = u.join("").replace(/#/g, "");
        return g = g.replace("++", "+")
    }, callMeCode = function (e, t, a, n, r, o) {
        for (var i = arguments.length > 6 && void 0 !== arguments[6] && arguments[6], s = arguments.length > 7 ? arguments[7] : void 0, c = e.length; c--;) !function (o) {
            var u = e[c];
            if (!0 === i) {
                u.innerHTML = t;
                var M = u.firstChild;
                u.parentNode.replaceChild(M, u), M.addEventListener("click", function (e) {
                    n(a, null, function (e, t) {
                        M.innerHTML = e;
                        var a = -1 !== t.indexOf("+380800") ? t.replace("+380", "0") : -1 !== t.indexOf("380800") ? t.replace("380", "0") : "+".concat(t);
                        M.parentNode.replaceChild(M.firstChild, M), "A" === M.nodeName && M.setAttribute("href", "tel:" + a), /iphone|android|ie|blackberry|fennec/.test(navigator.userAgent.toLowerCase()) && (location.href = "tel:" + a)
                    })
                })
            } else {
                u.innerHTML = t;
                for (var g = u.firstChild, l = 0; l < s.length; l++) s[l].geoGroup === r.xpaths[a].geoGroup && (u.setAttribute("rngst-geoGroup", r.xpaths[a].geoGroup), u.setAttribute("rngst-id", a));
                g.addEventListener("click", function (e) {
                    n(a, s, function (e, t) {
                        for (var n = document.querySelectorAll('[rngst-geoGroup="'.concat(r.xpaths[a].geoGroup, '"]')), o = 0; o < n.length; o++) {
                            n[o].innerHTML = maskNumber(r.xpaths[n[o].getAttribute("rngst-id")].mask.replace("<t>", t), t);
                            var i = -1 !== t.indexOf("+380800") ? t.replace("+380", "0") : -1 !== t.indexOf("380800") ? t.replace("380", "0") : "+".concat(t);
                            "A" === n[o].nodeName && n[o].setAttribute("href", "tel:" + i), 0 == o && /iphone|android|ie|blackberry|fennec/.test(navigator.userAgent.toLowerCase()) && (location.href = "tel:" + i)
                        }
                    })
                })
            }
        }()
    }, buttonCode = function (e, t, a, n) {
        for (var r = arguments.length > 4 && void 0 !== arguments[4] && arguments[4], o = e.length; o--;) !function (i) {
            var s = e[o], c = s;
            if ("true" !== c.getAttribute("rngstbtn")) if (!0 === r) {
                c.innerHTML = t;
                var u = c.firstChild;
                u.setAttribute("rngstbtn", "true"), s.parentNode.replaceChild(u, s), u.addEventListener("click", function (e) {
                    n(a, function (e, t) {
                        var a = -1 !== t.indexOf("+380800") ? t.replace("+380", "0") : -1 !== t.indexOf("380800") ? t.replace("380", "0") : "+".concat(t);
                        u.innerHTML = e, u.parentNode.replaceChild(u.firstChild, u), "A" === u.nodeName && u.setAttribute("href", "tel:" + a), /iphone|android|ie|blackberry|fennec/.test(navigator.userAgent.toLowerCase()) && (location.href = "tel:" + a)
                    })
                })
            } else (c = s).innerHTML = t, c.setAttribute("rngstbtn", "true"), s.parentNode.replaceChild(c, s), c.firstChild.addEventListener("click", function (e) {
                n(a, function (e, t) {
                    var a = -1 !== t.indexOf("+380800") ? t.replace("+380", "0") : -1 !== t.indexOf("380800") ? t.replace("380", "0") : "+".concat(t);
                    c.innerHTML = e, "A" === c.nodeName && c.setAttribute("href", "tel:" + a), /iphone|android|ie|blackberry|fennec/.test(navigator.userAgent.toLowerCase()) && (location.href = "tel:" + a)
                })
            })
        }()
    }, findElementsByXPath = function (e) {
        for (var t = [], a = document.evaluate(e.xPath, document, null, XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null), n = 0, r = a.snapshotLength; n < r; n++) t.push(a.snapshotItem(n));
        return t
    }, getUrlParameter = function (e) {
        e = e.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var t = new RegExp("[\\?&]".concat(e, "=([^&#]*)")).exec(location.search),
            a = t ? decodeURIComponent(t[1].replace(/\+/g, " ")) : null;
        return a && a.length > 0 ? a : null
    }, handleIeLoad = function e(t, a) {
        "loaded" !== t.readyState && "completed" !== t.readyState ? setTimeout(function () {
            e(t, a)
        }, 100) : a()
    }, insertScriptElement = function (e, t) {
        var a = document.getElementsByTagName("script")[0], n = document.createElement("script");
        n.async = !0, n.src = e, n.type = "text/javascript", n.onload = t, handleIeLoad(n, t), a.parentNode.insertBefore(n, a)
    }, parseLocation = function (e, t) {
        navigator.geolocation && e.browserGeolocation && navigator.geolocation.getCurrentPosition(function (e) {
            state.geoLocation.latitude = e.coords.latitude, state.geoLocation.longitude = e.coords.longitude, state.geoLocation.accuracy = e.coords.accuracy;
            var a = "language=en&latlng=".concat(e.coords.latitude, ",").concat(e.coords.longitude);
            sendPayload("//maps.googleapis.com/maps/api/geocode/json", a, {
                forceGet: !0, onSuccess: function (e) {
                    var a = e.responseText, n = JSON.parse(a);
                    if ("OK" === n.status) for (var r = n.results[0].address_components, o = 0; o < r.length; ++o) "country" === r[o].types[0] && (state.geoLocation.country = r[o].long_name), "locality" === r[o].types[0] && (state.geoLocation.city = r[o].long_name);
                    t()
                }
            })
        }, noop_1)
    }, textNodesUnder = function (e) {
        for (var t, a = [], n = document.createTreeWalker(e, NodeFilter.SHOW_TEXT, null, !1); t = n.nextNode();) a.push(t);
        return a
    }, onlyInteger = function (e) {
        return e ? parseInt(e.replace(/[^0-9]+/g, ""), 10) : NaN
    }, checkMessengersSettings = function (e, t) {
        var a = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "all";
        if (t.inactive_project || t.ip_is_blocked) return !1;
        var n = void 0 !== e.userSettings.messengers,
            r = n && e.userSettings.messengers.telegram && 1 === e.userSettings.messengers.telegram.enabled && e.userSettings.messengers.telegram.bot_name.length > 0,
            o = n && e.userSettings.messengers.viber && 1 === e.userSettings.messengers.viber.enabled && e.userSettings.messengers.viber.bot_name.length > 0,
            i = n && e.userSettings.messengers.facebookMessenger && 1 === e.userSettings.messengers.facebookMessenger.enabled && e.userSettings.messengers.facebookMessenger.bot_id.length > 0;
        return "telegram" === a ? n && r : "viber" === a ? n && o : "facebookMessenger" === a ? n && i : n && r || n && o || n && i
    }, customTask = function (e, t) {
        log("Ringostat is connected through CustomTask"), state.clientId = e.get("clientId"), state.trackingId = e.get("trackingId"), t()
    }, noGaTask = function (e, t) {
        log("Ringostat is connected through noGaTask"), state.clientId = e.clientId, state.trackingId = e.trackingId, t()
    }, plugin = function (e) {
        return function (t) {
            var a = t.get("sendHitTask");
            log("Ringostat is connected as a plugin"), state.clientId = t.get("clientId"), state.trackingId = t.get("trackingId"), e(), t.set("sendHitTask", function (e) {
                a(e), sendCollect(e.get("hitType"), e.get("hitPayload"))
            })
        }
    }, initGa = function (e) {
        if (!0 !== config.userSettings.noGa) {
            var t = findGaTracker(window, config.ga);
            if (t) return void customTask(t, e);
            window[config.ga]("provide", "ringostat", plugin(e))
        } else {
            var a = findGaTracker(window);
            a && noGaTask(a, e)
        }
    }, mockGa = function () {
        !0 === config.userSettings.noGa || (window[config.ga] = function () {
            window[config.ga].q = window[config.ga].q || [], window[config.ga].q.push(arguments)
        })
    };
    Array.prototype.forEach || (Array.prototype.forEach = function (e) {
        var t, a;
        if (null == this) throw new TypeError("this is null or not defined");
        var n = Object(this), r = n.length >>> 0;
        if ("function" != typeof e) throw new TypeError(e + " is not a function");
        for (arguments.length > 1 && (t = arguments[1]), a = 0; a < r;) {
            var o;
            a in n && (o = n[a], e.call(t, o, a, n)), a++
        }
    }), String.prototype.includes || (String.prototype.includes = function (e, t) {
        return "number" != typeof t && (t = 0), !(t + e.length > this.length) && -1 !== this.indexOf(e, t)
    }), Array.prototype.includes || Object.defineProperty(Array.prototype, "includes", {
        value: function (e, t) {
            if (null == this) throw new TypeError('"this" is null or not defined');
            var a = Object(this), n = a.length >>> 0;
            if (0 === n) return !1;
            var r, o, i = 0 | t, s = Math.max(i >= 0 ? i : n - Math.abs(i), 0);
            for (; s < n;) {
                if ((r = a[s]) === (o = e) || "number" == typeof r && "number" == typeof o && isNaN(r) && isNaN(o)) return !0;
                s++
            }
            return !1
        }
    }), window.MutationObserver = window.MutationObserver || function (e) {
        function t(e) {
            this.i = [], this.m = e
        }

        function a(t) {
            var a, n = {
                type: null,
                target: null,
                addedNodes: [],
                removedNodes: [],
                previousSibling: null,
                nextSibling: null,
                attributeName: null,
                attributeNamespace: null,
                oldValue: null
            };
            for (a in t) n[a] !== e && t[a] !== e && (n[a] = t[a]);
            return n
        }

        function n(t, n) {
            var s = o(t, n);
            return function (u) {
                var M, g = u.length;
                n.a && 3 === t.nodeType && t.nodeValue !== s.a && u.push(new a({
                    type: "characterData",
                    target: t,
                    oldValue: s.a
                })), n.b && s.b && r(u, t, s.b, n.f), (n.c || n.g) && (M = function (t, n, o, s) {
                    function u(e, n, o, i, c) {
                        var u, g, l, d = e.length - 1;
                        for (c = -~((d - c) / 2); l = e.pop();) u = o[l.j], g = i[l.l], s.c && c && Math.abs(l.j - l.l) >= d && (t.push(a({
                            type: "childList",
                            target: n,
                            addedNodes: [u],
                            removedNodes: [u],
                            nextSibling: u.nextSibling,
                            previousSibling: u.previousSibling
                        })), c--), s.b && g.b && r(t, u, g.b, s.f), s.a && 3 === u.nodeType && u.nodeValue !== g.a && t.push(a({
                            type: "characterData",
                            target: u,
                            oldValue: g.a
                        })), s.g && M(u, g)
                    }

                    function M(n, o) {
                        for (var l, d, N, y, D, I = n.childNodes, j = o.c, p = I.length, f = j ? j.length : 0, m = 0, b = 0, z = 0; b < p || z < f;) y = I[b], D = (N = j[z]) && N.node, y === D ? (s.b && N.b && r(t, y, N.b, s.f), s.a && N.a !== e && y.nodeValue !== N.a && t.push(a({
                            type: "characterData",
                            target: y,
                            oldValue: N.a
                        })), d && u(d, n, I, j, m), s.g && (y.childNodes.length || N.c && N.c.length) && M(y, N), b++, z++) : (g = !0, l || (l = {}, d = []), y && (l[N = i(y)] || (l[N] = !0, -1 === (N = c(j, y, z, "node")) ? s.c && (t.push(a({
                            type: "childList",
                            target: n,
                            addedNodes: [y],
                            nextSibling: y.nextSibling,
                            previousSibling: y.previousSibling
                        })), m++) : d.push({
                            j: b,
                            l: N
                        })), b++), D && D !== I[b] && (l[N = i(D)] || (l[N] = !0, -1 === (N = c(I, D, b)) ? s.c && (t.push(a({
                            type: "childList",
                            target: o.node,
                            removedNodes: [D],
                            nextSibling: j[z + 1],
                            previousSibling: j[z - 1]
                        })), m--) : d.push({j: N, l: z})), z++));
                        d && u(d, n, I, j, m)
                    }

                    var g;
                    return M(n, o), g
                }(u, t, s, n)), (M || u.length !== g) && (s = o(t, n))
            }
        }

        function r(t, n, r, o) {
            for (var i, s, c = {}, u = n.attributes, g = u.length; g--;) s = (i = u[g]).name, o && o[s] === e || (M(n, i) !== r[s] && t.push(a({
                type: "attributes",
                target: n,
                attributeName: s,
                oldValue: r[s],
                attributeNamespace: i.namespaceURI
            })), c[s] = !0);
            for (s in r) c[s] || t.push(a({target: n, type: "attributes", attributeName: s, oldValue: r[s]}))
        }

        function o(e, t) {
            var a = !0;
            return function e(n) {
                var r = {node: n};
                return !t.a || 3 !== n.nodeType && 8 !== n.nodeType ? (t.b && a && 1 === n.nodeType && (r.b = s(n.attributes, function (e, a) {
                    return t.f && !t.f[a.name] || (e[a.name] = M(n, a)), e
                })), a && (t.c || t.a || t.b && t.g) && (r.c = function (e, t) {
                    for (var a = [], n = 0; n < e.length; n++) a[n] = t(e[n], n, e);
                    return a
                }(n.childNodes, e)), a = t.g) : r.a = n.nodeValue, r
            }(e)
        }

        function i(e) {
            try {
                return e.id || (e.mo_id = e.mo_id || g++)
            } catch (t) {
                try {
                    return e.nodeValue
                } catch (e) {
                    return g++
                }
            }
        }

        function s(e, t) {
            for (var a = {}, n = 0; n < e.length; n++) a = t(a, e[n], n, e);
            return a
        }

        function c(e, t, a, n) {
            for (; a < e.length; a++) if ((n ? e[a][n] : e[a]) === t) return a;
            return -1
        }

        t._period = 30, t.prototype = {
            observe: function (e, a) {
                for (var r = {
                    b: !!(a.attributes || a.attributeFilter || a.attributeOldValue),
                    c: !!a.childList,
                    g: !!a.subtree,
                    a: !(!a.characterData && !a.characterDataOldValue)
                }, o = this.i, i = 0; i < o.length; i++) o[i].s === e && o.splice(i, 1);
                a.attributeFilter && (r.f = s(a.attributeFilter, function (e, t) {
                    return e[t] = !0, e
                })), o.push({s: e, o: n(e, r)}), this.h || function (e) {
                    !function a() {
                        var n = e.takeRecords();
                        n.length && e.m(n, e), e.h = setTimeout(a, t._period)
                    }()
                }(this)
            }, takeRecords: function () {
                for (var e = [], t = this.i, a = 0; a < t.length; a++) t[a].o(e);
                return e
            }, disconnect: function () {
                this.i = [], clearTimeout(this.h), this.h = null
            }
        };
        var u = document.createElement("i");
        u.style.top = 0;
        var M = (u = "null" != u.attributes.style.value) ? function (e, t) {
            return t.value
        } : function (e, t) {
            return "style" !== t.name ? t.value : e.style.cssText
        }, g = 1;
        return t
    }(void 0);
    var getNumbers = function (e) {
        var t = computeChangeNumberParams({
            clientId: state.clientId,
            cookie: readCookie(config.cookies.rngst2, !1),
            firstRequest: state.firstRequest,
            forceNumber: !1,
            geoLocation: state.geoLocation,
            pageViewId: state.pageViewId,
            projectHash: config.ringostatProjectHash,
            sl: state.sl
        });
        state.firstRequest = !1, sendPayload(config.urls.changedNumber, t, {
            onError: function (e) {
                log(e), config.changedNumberCallback({cnr: !1})
            }, onSuccess: e
        })
    }, setSimpleNumbers = function (e, t) {
        var a, n, r;
        "observeDOM" !== t && e.notifyAllObservers("numbers.beforeSetWithoutObserve", state.numbersData);
        var o = function (e) {
            if (!state.numbersData.numbers) return "break";
            var t, o, i, s = "", c = 0, u = 1, M = 1, g = 1, l = void 0, d = "", N = "", y = "", D = "", I = "",
                j = void 0;
            if (!state.numbersData.hasOwnProperty(e)) return "continue";
            if (r = e, n = config.phoneNumber, log("Number: ".concat(r, " for phoneNumber[").concat(n, "]")), !n || !r) return "continue";
            for (; 10 !== c;) s = (l = n[n.length - u]) + s, isNaN(l) || " " === l || c++, n.length === u && (c = 10), u++;
            i = s.replace(/(\D)/g, "(\\D*?)").replace("(\\D*?)(\\D*?)", "(\\D*?)"), t = new RegExp(i, "gi"), o = s.replace(/\d/g, "Y"), j = s.replace(/(\D)/g, "(\\D*?)").replace("(\\D*?)(\\D*?)", "(\\D*?)").split(")");
            try {
                d = new RegExp(j[0] + ")", "gi")
            } catch (e) {
                d = new RegExp(j[0], "gi")
            }
            j.slice(1).forEach(function (e) {
                N = "".concat(N + e, ")")
            }), N = new RegExp(N.substring(0, N.length - 1), "gi"), u = 0;
            for (var p = r.substr(r.length - 10), f = 0, m = o.length; f < m; f++) "Y" === o[f] ? (y += p.toString()[u], M > 1 && (I += p.toString()[u]), u++) : "Y" === o[f - 1] && (y = "".concat(y, "$").concat(M), 1 === M && (D = y), M > 1 && (I = "".concat(I, "$").concat(g), g++), M++);
            document.querySelectorAll("*:not(body)").forEach(function (e) {
                void 0 !== e.innerText && e.innerText.match(d) && (e.normalize(), textNodesUnder(e).forEach(function (e) {
                    void 0 !== e.nodeValue && "none" !== e && e.nodeValue.match(t) ? (e.nodeValue = e.nodeValue.replace(t, y), e.parentNode.hasAttribute("href") && (e.parentNode.href = "tel:+".concat(r))) : void 0 !== e.nodeValue && e.nodeValue.match(d) && e.parentNode.nextSibling && e.parentNode.nextSibling.nodeValue && e.parentNode.nextSibling.nodeValue.match(N) && (e.nodeValue = e.nodeValue.replace(d, D), e.parentNode.nextSibling.nodeValue = e.parentNode.nextSibling.nodeValue.replace(N, I), e.parentNode.parentNode.hasAttribute("href") && (e.parentNode.parentNode.href = "tel:+".concat(r)))
                }))
            }), a = !0
        };
        e:for (var i in state.numbersData) {
            switch (o(i)) {
                case"break":
                    break e;
                case"continue":
                    continue
            }
        }
        config.callbackFunctionBehavior && !a || "function" == typeof config.userSettings.callbackFunction && config.userSettings.callbackFunction()
    }, forceNumberCheck = function (e) {
        state.numbersData.checkOnClient && state.numbersData.checkOnClient.includes(e) && (state.numbersData.checkOnClient.splice(state.numbersData.checkOnClient.indexOf(e), 1), 0 === state.numbersData.checkOnClient.length && delete state.numbersData.checkOnClient), state.numbersData.callMe && state.numbersData.callMe.includes(e) && (state.numbersData.callMe.splice(state.numbersData.callMe.indexOf(e), 1), 0 === state.numbersData.callMe.length && delete state.numbersData.callMe)
    }, forceNumberFunction = function (e) {
        var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null,
            a = arguments.length > 2 ? arguments[2] : void 0, n = computeChangeNumberParams({
                clientId: state.clientId,
                cookie: readCookie(config.cookies.rngst2, !1),
                firstRequest: state.firstRequest,
                forceNumber: !0,
                geoLocation: state.geoLocation,
                pageViewId: state.pageViewId,
                projectHash: config.ringostatProjectHash
            }), r = "".concat(n, "&r_x=").concat(e);
        state.firstRequest = !1, sendPayload(config.urls.changedNumber, r, {
            onError: function (e) {
                log(e)
            }, onSuccess: function (n) {
                var r = n.responseText, o = JSON.parse(r), i = Object.keys(o)[0];
                for (var s in void 0 === state.numbersData[i] && (state.numbersData[i] = []), state.numbersData) if (Array.isArray(state.numbersData[s]) && state.numbersData[s].includes(e)) {
                    if (!(i in state.numbersData)) if (null === t) state.numbersData[i] = [e]; else for (var c in t) state.numbersData[i].push(parseInt(t[c].xpathId, 10)), forceNumberCheck(parseInt(t[c].xpathId, 10));
                    if (state.numbersData[i].includes(e)) if (null === t) forceNumberCheck(e); else for (var u in t) forceNumberCheck(parseInt(t[u].xpathId, 10)); else if (null === t) state.numbersData[i].length > 0 ? state.numbersData[i].push(parseInt(e, 10)) : state.numbersData[i] = [e], forceNumberCheck(e); else for (var M in t) state.numbersData[i].push(parseInt(t[M].xpathId, 10)), forceNumberCheck(parseInt(t[M].xpathId, 10))
                }
                createCookie(config.cookies.rngst1, state.numbersData, config.sessionLength, config.cookieDomain), "function" == typeof a && a(maskNumber(config.xpaths[e].mask.replace("<t>", i), i), i)
            }
        })
    }, isNumber = function (e) {
        return e && /^\d+$/.test(e)
    }, isCallMe = function (e) {
        return e && "callMe" === e
    }, isCheckOnClient = function (e) {
        return e && "checkOnClient" === e
    }, xPathsInOneGeoGroup = function (e) {
        if (void 0 === e) return [];
        for (var t = [], a = {}, n = 0; n < e.length; n++) e[n].xpathId = n, t.push(e[n].geoGroup);
        for (var r = t.filter(function (e, a) {
            return t.indexOf(e) === a
        }), o = 0; o < r.length; o++) a[r[o]] = e.filter(function (e) {
            return e.geoGroup === r[o]
        });
        return a
    }, setNumbers = function (e, t, a) {
        var n, r, o, i;
        for (var s in "observeDOM" !== a && e.notifyAllObservers("numbers.beforeSetWithoutObserve", state.numbersData), state.numbersData) {
            if (!state.numbersData.hasOwnProperty(s) || !state.numbersData.numbers) break;
            i = s;
            var c = function (a) {
                if (!state.numbersData[s].hasOwnProperty(a)) return "continue";
                if (r = state.numbersData[s][a], o = config.xpaths[r], log("Number: " + i + " for Xpath[" + r + "]: " + JSON.stringify(o, null, 2)), !o || !i) return "continue";
                var c = findElementsByXPath(o);
                if (isNumber(i)) for (var u in c) if (c.hasOwnProperty(u)) if (!0 === config.userSettings.replaceXpaths) {
                    c[u].innerHTML = maskNumber(o.mask.replace("<t>", i), i);
                    var M = c[u].firstChild;
                    c[u].parentNode.replaceChild(M, c[u])
                } else c[u].innerHTML = a, c[u].innerHTML = maskNumber(o.mask.replace("<t>", i), i), c[u].hasAttribute("href") && (c[u].href = "tel:+" + i);
                if (isCallMe(i) && "" !== o.callMeHTML) {
                    var g = c, l = g.length;
                    if (c.length > 0) for (callMeCode(c, o.callMeHTML, r, forceNumberFunction, config, findElementsByXPath, config.userSettings.replaceXpaths, t[o.geoGroup]); l--;) "A" === g[l].nodeName && g[l].removeAttribute("href")
                }
                isCheckOnClient(i) && "1" === o.checkOnClient && c.length > 0 && function () {
                    var t = c, a = t.length;
                    forceNumberFunction(r, null, function (n, r) {
                        for (e.notifyAllObservers("numbers.beforeSetWithoutObserve", state.numbersData); a--;) t[a].innerHTML = n, t[a].hasAttribute("href") && (t[a].href = "tel:+" + r)
                    })
                }(), n = !0
            };
            for (var u in state.numbersData[s]) c(u)
        }
        config.callbackFunctionBehavior && !n || "function" == typeof config.userSettings.callbackFunction && config.userSettings.callbackFunction()
    }, unique = function (e, t) {
        for (var a = {}, n = e.length - 1; n >= 0; --n) a[e[n]] = e[n];
        for (var r = t.length - 1; r >= 0; --r) a[t[r]] = t[r];
        var o = [];
        for (var i in a) a.hasOwnProperty(i) && o.push(a[i]);
        return o
    }, diff = function (e, t) {
        for (var a = 0; a < t.length; a++) for (var n = 0; n < e.length; n++) t[a] === e[n] && t.splice(a, 1);
        return t
    }, xPathsInOneGroup = xPathsInOneGeoGroup(config.xpaths), observeDOM = function () {
        var e;
        return {
            getInstance: function (t) {
                return e || (e = function (e) {
                    var t = null, a = null, n = {attributes: !0, childList: !0, subtree: !0},
                        r = new MutationObserver(function () {
                            var r = this;
                            r.disconnect(), clearTimeout(t), clearTimeout(a), t = setTimeout(function () {
                                config.isAdvanced ? setNumbers(e, xPathsInOneGroup, "observeDOM") : setSimpleNumbers(e, "observeDOM"), log("MutationObserver complete after 100 ms")
                            }, 100), a = setTimeout(function () {
                                config.isAdvanced ? setNumbers(e, xPathsInOneGroup, "observeDOM") : setSimpleNumbers(e, "observeDOM"), r.observe(document.body, n), log("MutationObserver complete after 2500 ms")
                            }, 2500)
                        });
                    return r.observe(document.body, n), {
                        disconnect: function () {
                            r.disconnect()
                        }
                    }
                }(t)), e
            }
        }
    }(), changeNumbers = function (e) {
        if (0 !== config.substitutionStatus) {
            if (!1 !== config.substitutionEnabled) return readCookie(config.cookies.rngst1, !1) ? (state.numbersData = readCookie(config.cookies.rngst1, !0), refreshCookie(config.cookies.rngst1, config.sessionLength, config.cookieDomain), config.isAdvanced && state.numbersData && state.numbersData.numbers ? setNumbers(e, xPathsInOneGroup) : setSimpleNumbers(e), void (config.observeDOM && observeDOM.getInstance(e))) : void getNumbers(function (t) {
                var a = t.responseText, n = t.status, r = t.statusText, o = JSON.parse(a);
                if (o && "inactiveProject" === o.msg && console.log("Ringostat: Inactive project"), state.numbersData = o && o.numbers ? o.numbers : null, void 0 !== state.numbersData.callMe && state.numbersData.callMe.length > 0) {
                    var i = null, s = [];
                    for (var c in o.numbers) if (isNumber(c)) {
                        for (var u = 0; u < o.numbers[c].length; u++) if ("1" === config.xpaths[o.numbers[c][u]].callMeAll) for (var M in i = xPathsInOneGeoGroup(config.xpaths)) s.push(parseInt(i[M].xpathId, 10));
                        state.numbersData[c] = unique(state.numbersData[c], s), state.numbersData.callMe = diff(state.numbersData[c], state.numbersData.callMe)
                    }
                }
                var g = state.numbersData, l = {utmz: o && o.utmz ? o.utmz : null};
                o && o.sl && (l.sl = o.sl, state.sl = o.sl), createCookie(config.cookies.rngst1, g, config.sessionLength, config.cookieDomain), readCookie(config.cookies.rngst2, !1) && !state.sl || createCookie(config.cookies.rngst2, l, 31536e3, config.cookieDomain), log("getChangedNumber Success : ".concat(n, " - ").concat(r)), config.isAdvanced && state.numbersData && state.numbersData.numbers ? setNumbers(e, xPathsInOneGroup) : setSimpleNumbers(e), config.observeDOM && observeDOM.getInstance(e)
            });
            console.log("Ringostat: Substitution is disabled by initChangeNumber() on changeNumbers()")
        } else console.log("Ringostat: Insertion status is OFF")
    }, Observer = function () {
    };
    Observer.prototype.notify = function () {
        console.error("Observer.notify() must be implemented")
    };
    var AtLeastOneNumberObserver = function () {
    };
    AtLeastOneNumberObserver.prototype = Object.create(Observer.prototype), AtLeastOneNumberObserver.prototype.constructor = AtLeastOneNumberObserver, AtLeastOneNumberObserver.prototype.notify = function (e) {
        var t = !1;
        if (e) for (var a in e) if (e.hasOwnProperty(a) && isNumber(a)) {
            t = !0;
            break
        }
        config.changedNumberCallback({cnr: t})
    };
    var Observable = function () {
        var e = [];
        return {
            subscribeObserver: function (t, a) {
                e[t] || (e[t] = []), e[t].push(a)
            }, unsubscribeObserver: function (t, a) {
                if (e[t]) {
                    var n = e[t].indexOf(a);
                    n > -1 && e[t].splice(n, 1)
                }
            }, notifyAllObservers: function (t, a) {
                if (e[t]) for (var n = 0; n < e[t].length; n += 1) e[t][n].notify(a)
            }
        }
    }, createObservable = function () {
        var e = new Observable;
        return e.subscribeObserver("numbers.beforeSetWithoutObserve", new AtLeastOneNumberObserver), e
    }, basic = function () {
        var e = createObservable(), t = function () {
            Date.now() - state.lastInteractionTime < config.pingInterval && (sendPing(), config.substitutionEnabled && refreshCookie(config.cookies.rngst1, config.sessionLength, config.cookieDomain))
        };
        initGa(function () {
            if (state.lastInteractionTime = Date.now(), addEvents(document, config.interactionEvents, function () {
                var t = Date.now();
                t - state.lastInteractionTime > config.sessionLengthMS && changeNumbers(e), state.lastInteractionTime = t
            }), setInterval(t, config.pingInterval), config.crossDomainTracking && getUrlParameter("_ga") && (log('Found GET parameter "_ga". Remove '.concat(config.cookies.rngst1, " & ").concat(config.cookies.rngst2, " cookies")), eraseCookie(config.cookies.rngst1, config.cookieDomain), eraseCookie(config.cookies.rngst2, config.cookieDomain)), !1 !== config.substitutionEnabled) {
                var a = readCookie(config.cookies.rngst2, !0);
                if (a) {
                    state.sl = a.sl;
                    if (function () {
                        for (var e = ["utm_source", "utm_medium", "utm_campaign", "utm_content", "utm_term", "utm_keyword", "gclid", "yclid", "dclid", "openstat"], t = 0; t <= e.length; t++) {
                            var n = e[t];
                            if (void 0 !== n) {
                                var r = getUrlParameter(n);
                                if (r && a.utmz[n] !== r) return !0
                            }
                        }
                        return !1
                    }()) eraseCookie(config.cookies.rngst1, config.cookieDomain), eraseCookie(config.cookies.rngst2, config.cookieDomain), changeNumbers(e); else {
                        var n = config.disableChangingNumber;
                        !0 !== navigator.cookieEnabled || n && readCookie(n, !1) || (readCookie(config.cookies.rngst1, !1) || parseLocation(config, function () {
                            eraseCookie(config.cookies.rngst1, config.cookieDomain), changeNumbers(e)
                        }), changeNumbers(e))
                    }
                } else eraseCookie(config.cookies.rngst1, config.cookieDomain), changeNumbers(e)
            } else log("Substitution is disabled by initChangeNumber() on initGaPlugin()")
        }), window.ringostatAnalytics = {
            sendPayload: sendCollect,
            sendHit: sendHit
        }, window.ringostatRestartSubstitution = function () {
            config.isAdvanced ? setNumbers(e, "client") : setSimpleNumbers(e, "client")
        }
    }, numberTag = "[object Number]";

    function isNumber$1(e) {
        return "number" == typeof e || isObjectLike_1(e) && _baseGetTag(e) == numberTag
    }

    var isNumber_1 = isNumber$1;

    function isNaN$1(e) {
        return isNumber_1(e) && e != +e
    }

    var _isNaN = isNaN$1;

    function arrayEach(e, t) {
        for (var a = -1, n = null == e ? 0 : e.length; ++a < n && !1 !== t(e[a], a, e);) ;
        return e
    }

    var _arrayEach = arrayEach;

    function createBaseFor(e) {
        return function (t, a, n) {
            for (var r = -1, o = Object(t), i = n(t), s = i.length; s--;) {
                var c = i[e ? s : ++r];
                if (!1 === a(o[c], c, o)) break
            }
            return t
        }
    }

    var _createBaseFor = createBaseFor, baseFor = _createBaseFor(), _baseFor = baseFor;

    function baseTimes(e, t) {
        for (var a = -1, n = Array(e); ++a < e;) n[a] = t(a);
        return n
    }

    var _baseTimes = baseTimes;

    function stubFalse() {
        return !1
    }

    var stubFalse_1 = stubFalse, isBuffer_1 = createCommonjsModule(function (e, t) {
            var a = t && !t.nodeType && t, n = a && e && !e.nodeType && e, r = n && n.exports === a ? _root.Buffer : void 0,
                o = (r ? r.isBuffer : void 0) || stubFalse_1;
            e.exports = o
        }), argsTag$1 = "[object Arguments]", arrayTag = "[object Array]", boolTag = "[object Boolean]",
        dateTag = "[object Date]", errorTag = "[object Error]", funcTag$1 = "[object Function]",
        mapTag = "[object Map]", numberTag$1 = "[object Number]", objectTag = "[object Object]",
        regexpTag = "[object RegExp]", setTag = "[object Set]", stringTag = "[object String]",
        weakMapTag = "[object WeakMap]", arrayBufferTag = "[object ArrayBuffer]", dataViewTag = "[object DataView]",
        float32Tag = "[object Float32Array]", float64Tag = "[object Float64Array]", int8Tag = "[object Int8Array]",
        int16Tag = "[object Int16Array]", int32Tag = "[object Int32Array]", uint8Tag = "[object Uint8Array]",
        uint8ClampedTag = "[object Uint8ClampedArray]", uint16Tag = "[object Uint16Array]",
        uint32Tag = "[object Uint32Array]", typedArrayTags = {};

    function baseIsTypedArray(e) {
        return isObjectLike_1(e) && isLength_1(e.length) && !!typedArrayTags[_baseGetTag(e)]
    }

    typedArrayTags[float32Tag] = typedArrayTags[float64Tag] = typedArrayTags[int8Tag] = typedArrayTags[int16Tag] = typedArrayTags[int32Tag] = typedArrayTags[uint8Tag] = typedArrayTags[uint8ClampedTag] = typedArrayTags[uint16Tag] = typedArrayTags[uint32Tag] = !0, typedArrayTags[argsTag$1] = typedArrayTags[arrayTag] = typedArrayTags[arrayBufferTag] = typedArrayTags[boolTag] = typedArrayTags[dataViewTag] = typedArrayTags[dateTag] = typedArrayTags[errorTag] = typedArrayTags[funcTag$1] = typedArrayTags[mapTag] = typedArrayTags[numberTag$1] = typedArrayTags[objectTag] = typedArrayTags[regexpTag] = typedArrayTags[setTag] = typedArrayTags[stringTag] = typedArrayTags[weakMapTag] = !1;
    var _baseIsTypedArray = baseIsTypedArray;

    function baseUnary(e) {
        return function (t) {
            return e(t)
        }
    }

    var _baseUnary = baseUnary, _nodeUtil = createCommonjsModule(function (e, t) {
            var a = t && !t.nodeType && t, n = a && e && !e.nodeType && e, r = n && n.exports === a && _freeGlobal.process,
                o = function () {
                    try {
                        return r && r.binding && r.binding("util")
                    } catch (e) {
                    }
                }();
            e.exports = o
        }), nodeIsTypedArray = _nodeUtil && _nodeUtil.isTypedArray,
        isTypedArray = nodeIsTypedArray ? _baseUnary(nodeIsTypedArray) : _baseIsTypedArray,
        isTypedArray_1 = isTypedArray, objectProto$7 = Object.prototype,
        hasOwnProperty$6 = objectProto$7.hasOwnProperty;

    function arrayLikeKeys(e, t) {
        var a = isArray_1(e), n = !a && isArguments_1(e), r = !a && !n && isBuffer_1(e),
            o = !a && !n && !r && isTypedArray_1(e), i = a || n || r || o, s = i ? _baseTimes(e.length, String) : [],
            c = s.length;
        for (var u in e) !t && !hasOwnProperty$6.call(e, u) || i && ("length" == u || r && ("offset" == u || "parent" == u) || o && ("buffer" == u || "byteLength" == u || "byteOffset" == u) || _isIndex(u, c)) || s.push(u);
        return s
    }

    var _arrayLikeKeys = arrayLikeKeys, objectProto$8 = Object.prototype;

    function isPrototype(e) {
        var t = e && e.constructor;
        return e === ("function" == typeof t && t.prototype || objectProto$8)
    }

    var _isPrototype = isPrototype;

    function overArg(e, t) {
        return function (a) {
            return e(t(a))
        }
    }

    var _overArg = overArg, nativeKeys = _overArg(Object.keys, Object), _nativeKeys = nativeKeys,
        objectProto$9 = Object.prototype, hasOwnProperty$7 = objectProto$9.hasOwnProperty;

    function baseKeys(e) {
        if (!_isPrototype(e)) return _nativeKeys(e);
        var t = [];
        for (var a in Object(e)) hasOwnProperty$7.call(e, a) && "constructor" != a && t.push(a);
        return t
    }

    var _baseKeys = baseKeys;

    function keys(e) {
        return isArrayLike_1(e) ? _arrayLikeKeys(e) : _baseKeys(e)
    }

    var keys_1 = keys;

    function baseForOwn(e, t) {
        return e && _baseFor(e, t, keys_1)
    }

    var _baseForOwn = baseForOwn;

    function createBaseEach(e, t) {
        return function (a, n) {
            if (null == a) return a;
            if (!isArrayLike_1(a)) return e(a, n);
            for (var r = a.length, o = t ? r : -1, i = Object(a); (t ? o-- : ++o < r) && !1 !== n(i[o], o, i);) ;
            return a
        }
    }

    var _createBaseEach = createBaseEach, baseEach = _createBaseEach(_baseForOwn), _baseEach = baseEach;

    function identity(e) {
        return e
    }

    var identity_1 = identity;

    function castFunction(e) {
        return "function" == typeof e ? e : identity_1
    }

    var _castFunction = castFunction;

    function forEach(e, t) {
        return (isArray_1(e) ? _arrayEach : _baseEach)(e, _castFunction(t))
    }

    var forEach_1 = forEach;

    function baseClamp(e, t, a) {
        return e == e && (void 0 !== a && (e = e <= a ? e : a), void 0 !== t && (e = e >= t ? e : t)), e
    }

    var _baseClamp = baseClamp;

    function toInteger(e) {
        var t = toFinite_1(e), a = t % 1;
        return t == t ? a ? t - a : t : 0
    }

    var toInteger_1 = toInteger;

    function startsWith(e, t, a) {
        return e = toString_1(e), a = null == a ? 0 : _baseClamp(toInteger_1(a), 0, e.length), t = _baseToString(t), e.slice(a, a + t.length) == t
    }

    var startsWith_1 = startsWith;

    function head(e) {
        return e && e.length ? e[0] : void 0
    }

    var head_1 = head;

    function isNull(e) {
        return null === e
    }

    var isNull_1 = isNull, getNumber = function (e, t) {
        var a = computeChangeNumberParams({
            clientId: state.clientId,
            cookie: readCookie(config.cookies.rngst2, !1),
            firstRequest: state.firstRequest,
            forceNumber: null,
            geoLocation: state.geoLocation,
            pageViewId: state.pageViewId,
            projectHash: config.ringostatProjectHash,
            adId: state.adId,
            xPathId: e,
            sl: state.sl
        });
        state.firstRequest = !1, state.customAdNumber && (a += "&r_can=".concat(state.customAdNumber)), sendPayload(config.urls.changedNumber, a, {onSuccess: t})
    }, clickHandler = function (e, t) {
        getNumber(e, function (a) {
            var n = a.status, r = a.readyState, o = a.responseText;
            if (200 === n || 4 === r) try {
                var i = JSON.parse(o);
                i && "inactiveProject" === i.msg && console.log("Ringostat: Inactive project"), state.numbersData = i && i.numbers ? i.numbers : null;
                var s = {utmz: i && i.utmz ? i.utmz : null};
                if (i && i.sl && (s.sl = i.sl, state.sl = i.sl), readCookie(config.cookies.rngst2, !1) && !state.sl || createCookie(config.cookies.rngst2, s, 31536e3, config.cookieDomain), isNull_1(state.numbersData)) return log("Numbers not found");
                var c = head_1(Object.keys(state.numbersData));
                c = startsWith_1(c, "+") ? c : "+" + c, t(maskNumber(config.xpaths[e].mask.replace("<t>", c), c), c)
            } catch (e) {
            }
        })
    }, observeDOM$1 = function () {
        var e;
        return {
            getInstance: function (t) {
                return e || (e = function (e) {
                    var t = new MutationObserver(function (t, a) {
                        forEach_1(t, function (t) {
                            "childList" === t.type && (null !== t.target.getAttribute("rngstbtn") && !1 !== t.target.getAttribute("rngstbtn") || replaceWithButton(e, "observeDOM"))
                        })
                    });
                    return t.observe(document.body, {
                        attributes: !0,
                        childList: !0,
                        subtree: !0
                    }), {
                        disconnect: function () {
                            t.disconnect()
                        }
                    }
                }(t)), e
            }
        }
    }(), processXPaths = function (e) {
        replaceWithButton(e), config.observeDOM && observeDOM$1.getInstance(e)
    }, replaceWithButton = function (e, t) {
        "observeDOM" !== t && e.notifyAllObservers("xpath.beforeSetWithoutObserve", "beforeSetWithoutObserve"), config.xpaths.forEach(function (e, t) {
            return buttonCode(findElementsByXPath(e), e.callMeHTML, t, clickHandler, config.userSettings.replaceXpaths)
        })
    }, AtLeastOneXpathObserver = function () {
    };
    AtLeastOneXpathObserver.prototype = Object.create(Observer.prototype), AtLeastOneXpathObserver.prototype.constructor = AtLeastOneXpathObserver, AtLeastOneXpathObserver.prototype.notify = function (e) {
        console.log(e)
    };
    var createObservableClassified = function () {
        var e = new Observable;
        return e.subscribeObserver("xpath.beforeSetWithoutObserve", new AtLeastOneXpathObserver), e
    }, classified = function () {
        var e = createObservableClassified(), t = function (e) {
            Date.now() - state.lastInteractionTime < config.pingInterval && sendPing(e)
        }, a = null;
        initGa(function () {
            var n = config.trackedEntities, r = n.adId, o = n.adNumber;
            if (isUndefined_1(r)) console.log('Project is not configured correctly, missing "adId"'); else {
                if (!1 !== config.userSettings.manualMode && void 0 !== config.userSettings.manualMode || (state.adId = computeAdditionalValue(r.value, r.type)), state.lastInteractionTime = Date.now(), o) {
                    var i = computeAdditionalValue(o.value, o.type);
                    if (i) {
                        var s = onlyInteger(i.toString().split(",", 1)[0]);
                        _isNaN(s) || (state.customAdNumber = s)
                    }
                }
                if (addEvents(document, config.interactionEvents, function () {
                    state.lastInteractionTime = Date.now()
                }), a = setInterval(t, config.pingInterval), config.crossDomainTracking && getUrlParameter("_ga") && (console.log('Ringostat: Found GET parameter "_ga". Remove '.concat(config.cookies.rngst2, " cookies")), eraseCookie(config.cookies.rngst2, config.cookieDomain)), 0 !== config.substitutionStatus) {
                    if (!1 !== config.substitutionEnabled) return isNil_1(state.adId) ? config.userSettings.manualMode ? log('Not found "adId"') : console.log('Not found "adId"') : void (!1 !== config.userSettings.manualMode && void 0 !== config.userSettings.manualMode || processXPaths(e));
                    console.log("Ringostat: Substitution is disabled by initChangeNumber() on initGa()")
                } else console.log("Ringostat: Insertion status is OFF")
            }
        }), window.ringostatAnalytics = {sendPayload: sendCollect}, window.getManualClassifiedNumber = function (e, n) {
            var r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : 0,
                o = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : null;
            if (0 !== config.substitutionStatus) {
                null !== a && (clearInterval(a), a = setInterval(function () {
                    return t(e)
                }, config.pingInterval));
                config.trackedEntities.adId;
                state.adId = computeAdditionalValue(e, "simple", !0), window.ringostatAnalytics.sendPayload("pageview", "", {}, e), state.customAdNumber = null !== o ? o : null, console.log(o || "null"), clickHandler(r, function (e, t) {
                    log("Returned numbers from getManualClassifiedNumber: number: ".concat(e, ", numberWithoutMask: ").concat(t)), n({
                        number: e,
                        numberWithoutMask: t
                    })
                })
            } else console.log("Ringostat: Insertion status is OFF")
        }
    }, substitution = Object.freeze({basic: basic, classified: classified}), bootstrap = function (e) {
        if (window[config.ga] || mockGa(), !1 === isUndefined_1(document.evaluate)) return substitution[e]();
        insertScriptElement("".concat(config.urls.backend, "static/js/vendors/wgxpath.install.js"), function () {
            wgxpath.install(), substitution[e]()
        })
    };

    function _typeof(e) {
        return (_typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        })(e)
    }

    function stackClear() {
        this.__data__ = new _ListCache, this.size = 0
    }

    var _stackClear = stackClear;

    function stackDelete(e) {
        var t = this.__data__, a = t.delete(e);
        return this.size = t.size, a
    }

    var _stackDelete = stackDelete;

    function stackGet(e) {
        return this.__data__.get(e)
    }

    var _stackGet = stackGet;

    function stackHas(e) {
        return this.__data__.has(e)
    }

    var _stackHas = stackHas, LARGE_ARRAY_SIZE = 200;

    function stackSet(e, t) {
        var a = this.__data__;
        if (a instanceof _ListCache) {
            var n = a.__data__;
            if (!_Map || n.length < LARGE_ARRAY_SIZE - 1) return n.push([e, t]), this.size = ++a.size, this;
            a = this.__data__ = new _MapCache(n)
        }
        return a.set(e, t), this.size = a.size, this
    }

    var _stackSet = stackSet;

    function Stack(e) {
        var t = this.__data__ = new _ListCache(e);
        this.size = t.size
    }

    Stack.prototype.clear = _stackClear, Stack.prototype.delete = _stackDelete, Stack.prototype.get = _stackGet, Stack.prototype.has = _stackHas, Stack.prototype.set = _stackSet;
    var _Stack = Stack, HASH_UNDEFINED$2 = "__lodash_hash_undefined__";

    function setCacheAdd(e) {
        return this.__data__.set(e, HASH_UNDEFINED$2), this
    }

    var _setCacheAdd = setCacheAdd;

    function setCacheHas(e) {
        return this.__data__.has(e)
    }

    var _setCacheHas = setCacheHas;

    function SetCache(e) {
        var t = -1, a = null == e ? 0 : e.length;
        for (this.__data__ = new _MapCache; ++t < a;) this.add(e[t])
    }

    SetCache.prototype.add = SetCache.prototype.push = _setCacheAdd, SetCache.prototype.has = _setCacheHas;
    var _SetCache = SetCache;

    function arraySome(e, t) {
        for (var a = -1, n = null == e ? 0 : e.length; ++a < n;) if (t(e[a], a, e)) return !0;
        return !1
    }

    var _arraySome = arraySome;

    function cacheHas(e, t) {
        return e.has(t)
    }

    var _cacheHas = cacheHas, COMPARE_PARTIAL_FLAG = 1, COMPARE_UNORDERED_FLAG = 2;

    function equalArrays(e, t, a, n, r, o) {
        var i = a & COMPARE_PARTIAL_FLAG, s = e.length, c = t.length;
        if (s != c && !(i && c > s)) return !1;
        var u = o.get(e);
        if (u && o.get(t)) return u == t;
        var M = -1, g = !0, l = a & COMPARE_UNORDERED_FLAG ? new _SetCache : void 0;
        for (o.set(e, t), o.set(t, e); ++M < s;) {
            var d = e[M], N = t[M];
            if (n) var y = i ? n(N, d, M, t, e, o) : n(d, N, M, e, t, o);
            if (void 0 !== y) {
                if (y) continue;
                g = !1;
                break
            }
            if (l) {
                if (!_arraySome(t, function (e, t) {
                    if (!_cacheHas(l, t) && (d === e || r(d, e, a, n, o))) return l.push(t)
                })) {
                    g = !1;
                    break
                }
            } else if (d !== N && !r(d, N, a, n, o)) {
                g = !1;
                break
            }
        }
        return o.delete(e), o.delete(t), g
    }

    var _equalArrays = equalArrays, Uint8Array$1 = _root.Uint8Array, _Uint8Array = Uint8Array$1;

    function mapToArray(e) {
        var t = -1, a = Array(e.size);
        return e.forEach(function (e, n) {
            a[++t] = [n, e]
        }), a
    }

    var _mapToArray = mapToArray;

    function setToArray(e) {
        var t = -1, a = Array(e.size);
        return e.forEach(function (e) {
            a[++t] = e
        }), a
    }

    var _setToArray = setToArray, COMPARE_PARTIAL_FLAG$1 = 1, COMPARE_UNORDERED_FLAG$1 = 2,
        boolTag$1 = "[object Boolean]", dateTag$1 = "[object Date]", errorTag$1 = "[object Error]",
        mapTag$1 = "[object Map]", numberTag$2 = "[object Number]", regexpTag$1 = "[object RegExp]",
        setTag$1 = "[object Set]", stringTag$1 = "[object String]", symbolTag$1 = "[object Symbol]",
        arrayBufferTag$1 = "[object ArrayBuffer]", dataViewTag$1 = "[object DataView]",
        symbolProto$1 = _Symbol ? _Symbol.prototype : void 0,
        symbolValueOf = symbolProto$1 ? symbolProto$1.valueOf : void 0;

    function equalByTag(e, t, a, n, r, o, i) {
        switch (a) {
            case dataViewTag$1:
                if (e.byteLength != t.byteLength || e.byteOffset != t.byteOffset) return !1;
                e = e.buffer, t = t.buffer;
            case arrayBufferTag$1:
                return !(e.byteLength != t.byteLength || !o(new _Uint8Array(e), new _Uint8Array(t)));
            case boolTag$1:
            case dateTag$1:
            case numberTag$2:
                return eq_1(+e, +t);
            case errorTag$1:
                return e.name == t.name && e.message == t.message;
            case regexpTag$1:
            case stringTag$1:
                return e == t + "";
            case mapTag$1:
                var s = _mapToArray;
            case setTag$1:
                var c = n & COMPARE_PARTIAL_FLAG$1;
                if (s || (s = _setToArray), e.size != t.size && !c) return !1;
                var u = i.get(e);
                if (u) return u == t;
                n |= COMPARE_UNORDERED_FLAG$1, i.set(e, t);
                var M = _equalArrays(s(e), s(t), n, r, o, i);
                return i.delete(e), M;
            case symbolTag$1:
                if (symbolValueOf) return symbolValueOf.call(e) == symbolValueOf.call(t)
        }
        return !1
    }

    var _equalByTag = equalByTag;

    function arrayPush(e, t) {
        for (var a = -1, n = t.length, r = e.length; ++a < n;) e[r + a] = t[a];
        return e
    }

    var _arrayPush = arrayPush;

    function baseGetAllKeys(e, t, a) {
        var n = t(e);
        return isArray_1(e) ? n : _arrayPush(n, a(e))
    }

    var _baseGetAllKeys = baseGetAllKeys;

    function arrayFilter(e, t) {
        for (var a = -1, n = null == e ? 0 : e.length, r = 0, o = []; ++a < n;) {
            var i = e[a];
            t(i, a, e) && (o[r++] = i)
        }
        return o
    }

    var _arrayFilter = arrayFilter;

    function stubArray() {
        return []
    }

    var stubArray_1 = stubArray, objectProto$10 = Object.prototype,
        propertyIsEnumerable$1 = objectProto$10.propertyIsEnumerable, nativeGetSymbols = Object.getOwnPropertySymbols,
        getSymbols = nativeGetSymbols ? function (e) {
            return null == e ? [] : (e = Object(e), _arrayFilter(nativeGetSymbols(e), function (t) {
                return propertyIsEnumerable$1.call(e, t)
            }))
        } : stubArray_1, _getSymbols = getSymbols;

    function getAllKeys(e) {
        return _baseGetAllKeys(e, keys_1, _getSymbols)
    }

    var _getAllKeys = getAllKeys, COMPARE_PARTIAL_FLAG$2 = 1, objectProto$11 = Object.prototype,
        hasOwnProperty$8 = objectProto$11.hasOwnProperty;

    function equalObjects(e, t, a, n, r, o) {
        var i = a & COMPARE_PARTIAL_FLAG$2, s = _getAllKeys(e), c = s.length;
        if (c != _getAllKeys(t).length && !i) return !1;
        for (var u = c; u--;) {
            var M = s[u];
            if (!(i ? M in t : hasOwnProperty$8.call(t, M))) return !1
        }
        var g = o.get(e);
        if (g && o.get(t)) return g == t;
        var l = !0;
        o.set(e, t), o.set(t, e);
        for (var d = i; ++u < c;) {
            var N = e[M = s[u]], y = t[M];
            if (n) var D = i ? n(y, N, M, t, e, o) : n(N, y, M, e, t, o);
            if (!(void 0 === D ? N === y || r(N, y, a, n, o) : D)) {
                l = !1;
                break
            }
            d || (d = "constructor" == M)
        }
        if (l && !d) {
            var I = e.constructor, j = t.constructor;
            I != j && "constructor" in e && "constructor" in t && !("function" == typeof I && I instanceof I && "function" == typeof j && j instanceof j) && (l = !1)
        }
        return o.delete(e), o.delete(t), l
    }

    var _equalObjects = equalObjects, DataView = _getNative(_root, "DataView"), _DataView = DataView,
        Promise$1 = _getNative(_root, "Promise"), _Promise = Promise$1, Set = _getNative(_root, "Set"), _Set = Set,
        WeakMap = _getNative(_root, "WeakMap"), _WeakMap = WeakMap, mapTag$2 = "[object Map]",
        objectTag$1 = "[object Object]", promiseTag = "[object Promise]", setTag$2 = "[object Set]",
        weakMapTag$1 = "[object WeakMap]", dataViewTag$2 = "[object DataView]",
        dataViewCtorString = _toSource(_DataView), mapCtorString = _toSource(_Map),
        promiseCtorString = _toSource(_Promise), setCtorString = _toSource(_Set),
        weakMapCtorString = _toSource(_WeakMap), getTag = _baseGetTag;
    (_DataView && getTag(new _DataView(new ArrayBuffer(1))) != dataViewTag$2 || _Map && getTag(new _Map) != mapTag$2 || _Promise && getTag(_Promise.resolve()) != promiseTag || _Set && getTag(new _Set) != setTag$2 || _WeakMap && getTag(new _WeakMap) != weakMapTag$1) && (getTag = function (e) {
        var t = _baseGetTag(e), a = t == objectTag$1 ? e.constructor : void 0, n = a ? _toSource(a) : "";
        if (n) switch (n) {
            case dataViewCtorString:
                return dataViewTag$2;
            case mapCtorString:
                return mapTag$2;
            case promiseCtorString:
                return promiseTag;
            case setCtorString:
                return setTag$2;
            case weakMapCtorString:
                return weakMapTag$1
        }
        return t
    });
    var _getTag = getTag, COMPARE_PARTIAL_FLAG$3 = 1, argsTag$2 = "[object Arguments]", arrayTag$1 = "[object Array]",
        objectTag$2 = "[object Object]", objectProto$12 = Object.prototype,
        hasOwnProperty$9 = objectProto$12.hasOwnProperty;

    function baseIsEqualDeep(e, t, a, n, r, o) {
        var i = isArray_1(e), s = isArray_1(t), c = i ? arrayTag$1 : _getTag(e), u = s ? arrayTag$1 : _getTag(t),
            M = (c = c == argsTag$2 ? objectTag$2 : c) == objectTag$2,
            g = (u = u == argsTag$2 ? objectTag$2 : u) == objectTag$2, l = c == u;
        if (l && isBuffer_1(e)) {
            if (!isBuffer_1(t)) return !1;
            i = !0, M = !1
        }
        if (l && !M) return o || (o = new _Stack), i || isTypedArray_1(e) ? _equalArrays(e, t, a, n, r, o) : _equalByTag(e, t, c, a, n, r, o);
        if (!(a & COMPARE_PARTIAL_FLAG$3)) {
            var d = M && hasOwnProperty$9.call(e, "__wrapped__"), N = g && hasOwnProperty$9.call(t, "__wrapped__");
            if (d || N) {
                var y = d ? e.value() : e, D = N ? t.value() : t;
                return o || (o = new _Stack), r(y, D, a, n, o)
            }
        }
        return !!l && (o || (o = new _Stack), _equalObjects(e, t, a, n, r, o))
    }

    var _baseIsEqualDeep = baseIsEqualDeep;

    function baseIsEqual(e, t, a, n, r) {
        return e === t || (null == e || null == t || !isObjectLike_1(e) && !isObjectLike_1(t) ? e != e && t != t : _baseIsEqualDeep(e, t, a, n, baseIsEqual, r))
    }

    var _baseIsEqual = baseIsEqual, COMPARE_PARTIAL_FLAG$4 = 1, COMPARE_UNORDERED_FLAG$2 = 2;

    function baseIsMatch(e, t, a, n) {
        var r = a.length, o = r, i = !n;
        if (null == e) return !o;
        for (e = Object(e); r--;) {
            var s = a[r];
            if (i && s[2] ? s[1] !== e[s[0]] : !(s[0] in e)) return !1
        }
        for (; ++r < o;) {
            var c = (s = a[r])[0], u = e[c], M = s[1];
            if (i && s[2]) {
                if (void 0 === u && !(c in e)) return !1
            } else {
                var g = new _Stack;
                if (n) var l = n(u, M, c, e, t, g);
                if (!(void 0 === l ? _baseIsEqual(M, u, COMPARE_PARTIAL_FLAG$4 | COMPARE_UNORDERED_FLAG$2, n, g) : l)) return !1
            }
        }
        return !0
    }

    var _baseIsMatch = baseIsMatch;

    function isStrictComparable(e) {
        return e == e && !isObject_1(e)
    }

    var _isStrictComparable = isStrictComparable;

    function getMatchData(e) {
        for (var t = keys_1(e), a = t.length; a--;) {
            var n = t[a], r = e[n];
            t[a] = [n, r, _isStrictComparable(r)]
        }
        return t
    }

    var _getMatchData = getMatchData;

    function matchesStrictComparable(e, t) {
        return function (a) {
            return null != a && (a[e] === t && (void 0 !== t || e in Object(a)))
        }
    }

    var _matchesStrictComparable = matchesStrictComparable;

    function baseMatches(e) {
        var t = _getMatchData(e);
        return 1 == t.length && t[0][2] ? _matchesStrictComparable(t[0][0], t[0][1]) : function (a) {
            return a === e || _baseIsMatch(a, e, t)
        }
    }

    var _baseMatches = baseMatches;

    function baseGet(e, t) {
        for (var a = 0, n = (t = _castPath(t, e)).length; null != e && a < n;) e = e[_toKey(t[a++])];
        return a && a == n ? e : void 0
    }

    var _baseGet = baseGet;

    function get(e, t, a) {
        var n = null == e ? void 0 : _baseGet(e, t);
        return void 0 === n ? a : n
    }

    var get_1 = get;

    function baseHasIn(e, t) {
        return null != e && t in Object(e)
    }

    var _baseHasIn = baseHasIn;

    function hasIn(e, t) {
        return null != e && _hasPath(e, t, _baseHasIn)
    }

    var hasIn_1 = hasIn, COMPARE_PARTIAL_FLAG$5 = 1, COMPARE_UNORDERED_FLAG$3 = 2;

    function baseMatchesProperty(e, t) {
        return _isKey(e) && _isStrictComparable(t) ? _matchesStrictComparable(_toKey(e), t) : function (a) {
            var n = get_1(a, e);
            return void 0 === n && n === t ? hasIn_1(a, e) : _baseIsEqual(t, n, COMPARE_PARTIAL_FLAG$5 | COMPARE_UNORDERED_FLAG$3)
        }
    }

    var _baseMatchesProperty = baseMatchesProperty;

    function baseProperty(e) {
        return function (t) {
            return null == t ? void 0 : t[e]
        }
    }

    var _baseProperty = baseProperty;

    function basePropertyDeep(e) {
        return function (t) {
            return _baseGet(t, e)
        }
    }

    var _basePropertyDeep = basePropertyDeep;

    function property(e) {
        return _isKey(e) ? _baseProperty(_toKey(e)) : _basePropertyDeep(e)
    }

    var property_1 = property;

    function baseIteratee(e) {
        return "function" == typeof e ? e : null == e ? identity_1 : "object" == typeof e ? isArray_1(e) ? _baseMatchesProperty(e[0], e[1]) : _baseMatches(e) : property_1(e)
    }

    var _baseIteratee = baseIteratee;

    function baseMap(e, t) {
        var a = -1, n = isArrayLike_1(e) ? Array(e.length) : [];
        return _baseEach(e, function (e, r, o) {
            n[++a] = t(e, r, o)
        }), n
    }

    var _baseMap = baseMap;

    function map(e, t) {
        return (isArray_1(e) ? _arrayMap : _baseMap)(e, _baseIteratee(t, 3))
    }

    var map_1 = map, checkPathname = function (e) {
        if (e.pagesWhiteList.length) {
            for (var t = 0; t < e.pagesWhiteList.length; t++) {
                var a = e.pagesWhiteList[t];
                if (-1 != window.location.pathname.search(a)) return !0
            }
            return console.log("The pagesWhiteList is not empty and doesn't contain this page"), !1
        }
        if (e.pagesBlackList.length) for (var n = 0; n < e.pagesBlackList.length; n++) {
            var r = e.pagesBlackList[n];
            if (-1 != window.location.pathname.search(r)) return console.log("The pagesBlackList is not empty and contains this page"), !1
        }
        return !0
    }, trackForms = function (e, t) {
        var a = e.customFormDataTracking;
        if (checkPathname(a)) {
            for (var n = [], r = 0; r < a.phoneInputName.length; r++) n.push("input[name=" + a.phoneInputName[r] + "]");
            var o = n.join(", "), i = !1;
            if (a.isActive) for (var s = 0; s < document.forms.length; s++) {
                var c = document.forms[s];
                c.attachEvent ? c.attachEvent("submit", u) : c.onsubmit = u, log("Tracked form: #" + c.id)
            }
        }

        function u(e) {
            setTimeout(function () {
                e.defaultPrevented || (e.preventDefault(), i = !0);
                for (var n = e.target, r = {}, s = 0; s < n.elements.length; s++) if ("BUTTON" !== n.elements[s].tagName && "submit" !== n.elements[s].type && -1 === a.fieldsBlackList.indexOf(n.elements[s].name)) if ("SELECT" === n.elements[s].tagName && n.elements[s].multiple) r[n.elements[s].name] = [], map_1(n.elements[s].options, function (e, t) {
                    e.selected && r[n.elements[s].name].push(e.value)
                }); else {
                    if ("INPUT" === n.elements[s].tagName && "file" === n.elements[s].type) continue;
                    if ("INPUT" === n.elements[s].tagName && "radio" === n.elements[s].type && !n.elements[s].checked) continue;
                    r[n.elements[s].name] = n.elements[s].value
                }
                log("Stored data:" + JSON.stringify(r));
                var c = v4_1();
                sessionStorage.setItem("hit_id", c);
                var u = {
                    hid: c,
                    vid: state.pageViewId,
                    r_cl: state.clientId,
                    r_cu: window.location.href,
                    r_pd: getAdditionalData(config.trackedEntities, LEVEL_PAGEVIEW),
                    dt: document.title,
                    formData: r,
                    formId: n.id.length ? n.id : "",
                    formName: n.name.length ? n.name : ""
                };
                sendPayload(config.urls.apiV2, u, {
                    jsonRpc: !0, method: "saveFormData", onSuccess: function (n) {
                        log(n), !0 === a.startCallbackOnSubmitForm && null !== e.target.querySelector(o) && function (e) {
                            var n = e.target.querySelector(o).value.replace(/^(380|\+380)0/, "$1");
                            n = n.replace(/^(7|\+7)8/, "$1");
                            try {
                                void 0 !== a.callbackDuringBusinessHours && a.callbackDuringBusinessHours ? void 0 !== t.old_data && void 0 !== t.old_data.is_working_time && t.old_data.is_working_time && t.requestCallback({num_to_call: n}, null).then(function () {
                                }).catch(function () {
                                }) : t.requestCallback({num_to_call: n}, null).then(function () {
                                }).catch(function () {
                                })
                            } catch (e) {
                                log(e)
                            }
                        }(e), i && e.target.submit()
                    }
                })
            }, 3)
        }
    };

    function dec2hex(e) {
        return ("0" + e.toString(16)).substr(-2)
    }

    var generateRandomString = function (e) {
        var t = new Uint8Array((e || 40) / 2);
        return window.crypto.getRandomValues(t), Array.from(t, dec2hex).join("")
    }, ringostatCookieTLD = function () {
        for (var e, t = document.cookie, a = document.location.hostname.split("."), n = a.length; n--;) if (e = ".".concat(a.slice(n).join(".")), createCookie("CookieTLD", e, 30, e), t !== document.cookie) return eraseCookie("CookieTLD", e), e;
        return null
    }(), callback = function (e) {
        var t = ["mousedown", "click"];
        var a = {
            isMobile: /iphone|ipod|android|ie|blackberry|fennec/.test(navigator.userAgent.toLowerCase()),
            sendPost: function (e, t, n, r) {
                var o = new ("onload" in new XMLHttpRequest ? XMLHttpRequest : XDomainRequest);
                o.open("POST", e, !0), o.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"), o.onload = n, o.onerror = r, o.send(a.objectToQueryString(t))
            },
            maskString: function (e, t) {
                for (var a = t.toString().split(""), n = e.toString().split(""), r = a.length; r--;) -1 !== n.lastIndexOf("#") && (n[n.lastIndexOf("#")] = a[+r]);
                return n.join("").replace(/#/g, "")
            },
            getLocale: function () {
                return (document.documentElement.lang ? document.documentElement.lang : navigator ? navigator.language || navigator.userLanguage : "ru").split("-")[0]
            },
            deepExtend: function (e, t) {
                for (var n in t) t.hasOwnProperty(n) && (e || (e = {}), e[n] && "object" === _typeof(t[n]) ? a.deepExtend(e[n], t[n]) : e[n] = t[n]);
                return e
            },
            objectToQueryString: function (e) {
                function t(e, a, n) {
                    var r, o, i, s;
                    if (s = /\[\]$/, a instanceof Array) for (o = 0, i = a.length; o < i; o++) s.test(e) ? n(e, a[o]) : t("".concat(e, "[").concat("object" === _typeof(a[o]) ? o : "", "]"), a[o], n); else if ("object" === _typeof(a)) for (r in a) t("".concat(e, "[").concat(r, "]"), a[r], n); else n(e, a)
                }

                var a, n, r, o, i;
                if (n = [], i = /%20/g, r = function (e, t) {
                    t = "function" == typeof t ? t() : null == t ? "" : t, n[n.length] = "".concat(encodeURIComponent(e), "=").concat(encodeURIComponent(t))
                }, e instanceof Array) for (o in e) r(o, e[o]); else for (a in e) t(a, e[a], r);
                return n.join("&").replace(i, "+")
            },
            fadeIn: function (e) {
                e.style.opacity = 0, e.style.display = "flex", function t() {
                    var a = parseFloat(e.style.opacity);
                    (a += .1) > 1 || (e.style.opacity = a, requestAnimationFrame(t))
                }()
            },
            fadeOut: function (e, t) {
                var a = 1, n = setInterval(function () {
                    (a -= 10 / 300) <= 0 && (clearInterval(n), a = 0, e.style.display = "none", e.style.visibility = "hidden", "function" == typeof t && t()), e.style.opacity = a, e.style.filter = "alpha(opacity=".concat(100 * a, ")")
                }, 10)
            },
            addClass: function (e, t) {
                e.className += " ".concat(t)
            },
            removeClass: function (e, t) {
                e.className = e.className.replace(new RegExp("(^|\\b)".concat(t.split(" ").join("|"), "(\\b|$)"), "gi"), " ")
            },
            parseUrl: function (e) {
                var t = document.createElement("a");
                return t.href = e, t
            },
            throttle: function (e, t) {
                var a, n, r = !1;
                return function o() {
                    if (r) return a = arguments, void (n = this);
                    e.apply(this, arguments), r = !0, setTimeout(function () {
                        r = !1, a && (o.apply(n, a), a = n = null)
                    }, t)
                }
            }
        }, n = {
            currentUrl: window.location.href,
            referrer: document.referrer,
            referrerHost: a.parseUrl(document.referrer).hostname,
            currentHost: a.parseUrl(window.location.href).host
        }, r = {
            callback: null, interval: null, achieveTime: 0, guid: function () {
                function e() {
                    return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
                }

                return "".concat(e() + e(), "-").concat(e(), "-").concat(e(), "-").concat(e(), "-").concat(e()).concat(e()).concat(e())
            }(), isLocalStorageNameSupported: function () {
                var e = window.sessionStorage;
                try {
                    return e.setItem("test", "1"), e.removeItem("test"), !0
                } catch (e) {
                    return !1
                }
            }, init: function (e, t) {
                r.callback = t, r.achieveTime = e;
                var o = {guid: "", achiev: 0}, i = r.readFromStorage();
                if (i && i.achiev) {
                    if (-1 === i.achiev) {
                        if (!n.isLanding) return;
                        i.achiev = 0
                    }
                    o.achiev = i.achiev
                }
                r.writeToStorage(o);
                addEvents(document, ["mousedown", "mouseup", "mousemove", "touchstart", "touchmove", "touchend", "keydown", "keyup"], a.throttle(r.eventFired, 500)), null === r.interval && (r.interval = setInterval(function () {
                    (i = r.readFromStorage()) && i.guid === r.guid && (i.achiev >= r.achieveTime || -1 === i.achiev ? (clearInterval(r.interval), r.writeToStorage({
                        guid: "",
                        achiev: -1
                    }), r.callback()) : r.writeToStorage({guid: "", achiev: i.achiev + 10}))
                }, 1e4))
            }, eventFired: function () {
                var e = r.readFromStorage();
                e && (e.guid = r.guid, r.writeToStorage(e))
            }, writeToStorage: function (e) {
                var t = {value: e, expires_at: (new Date).getTime() + 18e5};
                r.isLocalStorageNameSupported() ? localStorage.setItem("rngst_action", JSON.stringify(t)) : createCookie("rngst_action", JSON.stringify(t))
            }, readFromStorage: function () {
                if (r.isLocalStorageNameSupported()) var e = JSON.parse(localStorage.getItem("rngst_action")); else readCookie("rngst_action", !0);
                if (null !== e) {
                    if (!(null !== e.expires_at && e.expires_at < (new Date).getTime())) return e.value;
                    localStorage.removeItem("rngst_action")
                }
                return null
            }
        }, o = {
            old_data: null,
            language: a.getLocale(),
            formType: null,
            form: null,
            button: null,
            icon: null,
            overlay: null,
            formStatus: "hidden",
            buttonStatus: "hidden",
            iframeDocument: null,
            tooltipText: {
                ru: "Есть вопросы? \n Свяжитесь с нами",
                en: "Any questions? \n Contact us",
                uk: "Є питання? \n Зв'яжіться з нами"
            },
            recaptcha_token: null,
            user_has_recaptcha: 0,
            setCallbackSettings: function (t) {
                e.callbackSettings = a.deepExtend({
                    CallbackOffOnPage: !1,
                    autoFormOffOnPage: !1,
                    CallbackOff: !1,
                    autoFormOff: !1,
                    delay: 0
                }, t), o.check()
            },
            hideButton: function () {
                var e = document.getElementsByClassName("rngst_phone_button")[0];
                e && !e.classList.contains("dropdown") && document.body.removeChild(e)
            },
            stopTimer: function () {
                r.callback = function () {
                }, r.writeToStorage({achiev: -1})
            },
            freezeTimer: function () {
                clearTimeout(r.interval)
            },
            check: function () {
                return e.callbackSettings.CallbackOff ? (o.hideButton(), o.stopTimer(), void createCookie("rngst_callback", {callbackNumber: !1}, 1800, e.cookieDomain)) : e.callbackSettings.CallbackOffOnPage ? (o.hideButton(), void o.freezeTimer()) : (readCookie("rngst_callback", !1) ? (o.old_data = readCookie("rngst_callback", !0), !1 === o.old_data.ip_is_blocked && !1 === o.old_data.inactive_project ? o.init() : log("No callback number")) : a.sendPost("".concat(e.urls.substitution, "api/checkCallback/"), {
                    "data[current_url]": n.currentUrl,
                    "data[language]": a.getLocale(),
                    "data[referrer]": n.referrer,
                    "data[ua_id]": n.uaId,
                    "data[utmz]": readCookie(e.cookies.rngst2, !1) && readCookie(e.cookies.rngst2, !0).utmz || ""
                }, function () {
                    o.old_data = JSON.parse(this.responseText), createCookie("rngst_callback", o.old_data, 1800, e.cookieDomain), !1 === o.old_data.ip_is_blocked && !1 === o.old_data.inactive_project ? o.init() : log("No callback number"), log("checkCallback  Success : ".concat(this.status, " - ").concat(this.statusText))
                }, function () {
                    log("checkCallback  Error : ".concat(this.status, " - ").concat(this.statusText))
                }), void (e.callbackSettings.hideCallbackButton && o.hideButton()))
            },
            checkMessenger: function () {
                var a = document.getElementsByTagName("head")[0], r = document.createElement("link");
                r.rel = "stylesheet", r.type = "text/css", r.href = "".concat(e.urls.substitution, "api/getCallbackButtonCSS/?ua_id=").concat(n.uaId), a.appendChild(r);
                var i = document.createElement("style");
                if (i.innerHTML = '.dropdown-content-rngst {    display: none;    position: absolute;    background-color: transparent;    z-index: 1;}.dropdown-content-rngst a {    color: black;    text-decoration: none;    display: block;}.messengers-icon {   width:100%;   height: 100%;}.messengers-icon-btn {   width: 50px;   height: 50px;   cursor: pointer;   padding: 0;   border: none;   background: none;   margin: 5px 0;}.dropdownMessengers.dropdownMessengers-show .dropdown-content-rngst {   background: #EDEDED;   padding: 20px 17px;   border-radius: 60px;   bottom: 0;    left: 57px;   z-index: 99999999;   display: flex;   align-items: flex-end;   flex-direction: column;   justify-content: space-around;}.dropdownMessengers.dropdownMessengers-show .dropbtn { display: none; }.messengers-icon-btn.messengers-icon-btn--tel {   padding: 0;   background: transparent;   border: none;}.messengers-icon-btn.messengers-icon-btn--tel:active, .messengers-icon-btn.messengers-icon-btn--tel:focus {   outline: none;}.rngst_phone_button.dropdownMessengers .rngst_phone_icon {    background-image: url("data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzkiIGhlaWdodD0iMzUiIHZpZXdCb3g9IjAgMCAzOSAzNSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBjbGlwLXBhdGg9InVybCgjY2xpcDApIj48cGF0aCBkPSJNMjMuNDQ1MiAyNC4yMjcxTDIwLjcxMDIgMjEuNDkyMUMxOS45NTYxIDIwLjczODEgMTguNzI5MSAyMC43MzgxIDE3Ljk3NTEgMjEuNDkyMUwxNi43MzE5IDIyLjczNTNDMTYuMTYwNyAyMy4zMDY1IDE1LjIzMTIgMjMuMzA2NCAxNC42NjAxIDIyLjczNTVMOS4yNzE1OSAxNy4zNDI0QzguNjk5MDEgMTYuNzY5OCA4LjY5ODkyIDE1Ljg0MyA5LjI3MTU5IDE1LjI3MDRDOS40NzE4NCAxNS4wNzAxIDEwLjA0NjggMTQuNDk1MSAxMC41MTQ4IDE0LjAyNzJDMTEuMjY1NSAxMy4yNzY1IDExLjI3NiAxMi4wNTMzIDEwLjUxNCAxMS4yOTE1TDcuNzc5NzQgOC41NjU3NUM3LjAyNTY5IDcuODExNzUgNS43OTg3NSA3LjgxMTc1IDUuMDQ2NzIgOC41NjM3OEM0LjQ4Mzk4IDkuMTIxNjIgNC4zMDI0NyA5LjMwMTU4IDQuMDUwMTUgOS41NTE3MUMxLjMzMDk2IDEyLjI3MDkgMS4zMzA5NiAxNi42OTUyIDQuMDUwMDIgMTkuNDE0M0wxMi41ODc5IDI3Ljk1NjdDMTUuMzEzNSAzMC42ODIzIDE5LjcyNDggMzAuNjgyNSAyMi40NTA2IDI3Ljk1NjdMMjMuNDQ1MiAyNi45NjIxQzI0LjE5OTMgMjYuMjA4MSAyNC4xOTkzIDI0Ljk4MTIgMjMuNDQ1MiAyNC4yMjcxWk01Ljk1NjQxIDkuNDc3NDJDNi4yMDc3NCA5LjIyNjA4IDYuNjE2NjUgOS4yMjYwNCA2Ljg2ODggOS40NzgxTDkuNjAzMTEgMTIuMjAzOEM5Ljg1NTA1IDEyLjQ1NTggOS44NTUwNSAxMi44NjM1IDkuNjAzMTEgMTMuMTE1NUw5LjE0NzI0IDEzLjU3MTNMNS41MDI5IDkuOTI2OThMNS45NTY0MSA5LjQ3NzQyWk0xMy40OTk4IDI3LjA0NTFMNC45NjE4MSAxOC41MDI3QzIuODU4MDUgMTYuMzk4OSAyLjc0MjQyIDEzLjA5NTUgNC42MDYxOSAxMC44NTM2TDguMjM5OTYgMTQuNDg3NEM3LjI4NTE1IDE1LjU2OTggNy4zMjQ5NCAxNy4yMTkxIDguMzU5NzEgMTguMjUzOUwxMy43NDgxIDIzLjY0NjhDMTMuNzQ4MSAyMy42NDY4IDEzLjc0ODIgMjMuNjQ2OSAxMy43NDgyIDIzLjY0NjlDMTQuNzgxOSAyNC42ODA2IDE2LjQzMTEgMjQuNzIzIDE3LjUxNDkgMjMuNzY2OUwyMS4xNDg3IDI3LjQwMDhDMTguOTEzOSAyOS4yNjEzIDE1LjYxOCAyOS4xNjM0IDEzLjQ5OTggMjcuMDQ1MVpNMjIuNTMzNiAyNi4wNTA1TDIyLjA3NzcgMjYuNTA2M0wxOC40MzEgMjIuODU5NkwxOC44ODY4IDIyLjQwMzhDMTkuMTM4MiAyMi4xNTI0IDE5LjU0NzEgMjIuMTUyNCAxOS43OTg1IDIyLjQwMzhMMjIuNTMzNSAyNS4xMzg4QzIyLjc4NDkgMjUuMzkwMiAyMi43ODQ5IDI1Ljc5OTIgMjIuNTMzNiAyNi4wNTA1WiIgZmlsbD0id2hpdGUiLz48L2c+PHBhdGggZD0iTTMyLjA2NjQgNi40ODc5MUgyNy41NTQ3VjMuMjY1MjVDMjcuNTU0NyAyLjE5OTA2IDI2LjY4NzMgMS4zMzE2NSAyNS42MjExIDEuMzMxNjVIMTMuOTMzNkMxMi44Njc0IDEuMzMxNjUgMTIgMi4xOTkwNiAxMiAzLjI2NTI1VjEwLjk5OTZDMTIgMTIuMDY1OCAxMi44Njc0IDEyLjkzMzIgMTMuOTMzNiAxMi45MzMySDE0LjU3ODFWMTQuODY2OEMxNC41NzgxIDE1LjM4MyAxNS4xNTQ3IDE1LjY4NjcgMTUuNTgwMiAxNS40MDMxTDE4LjQ0NTMgMTMuNDkzVjE2LjE1NTlDMTguNDQ1MyAxNy4yMjIxIDE5LjMxMjcgMTguMDg5NSAyMC4zNzg5IDE4LjA4OTVIMjYuNzE1TDMwLjQxOTggMjAuNTU5NEMzMC44NDU5IDIwLjg0MzUgMzEuNDIxOSAyMC41Mzk0IDMxLjQyMTkgMjAuMDIzMVYxOC4wODk1SDMyLjA2NjRDMzMuMTMyNiAxOC4wODk1IDM0IDE3LjIyMjEgMzQgMTYuMTU1OVY4LjQyMTUxQzM0IDcuMzU1MzIgMzMuMTMyNiA2LjQ4NzkxIDMyLjA2NjQgNi40ODc5MVpNMTguNzMwNiAxMS43NTM2QzE4LjczIDExLjc1NCAxOC43MjkzIDExLjc1NDQgMTguNzI4NyAxMS43NTQ4TDE1Ljg2NzIgMTMuNjYyNVYxMi4yODg3QzE1Ljg2NzIgMTEuOTMyNyAxNS41Nzg2IDExLjY0NDIgMTUuMjIyNyAxMS42NDQySDEzLjkzMzZDMTMuNTc4MiAxMS42NDQyIDEzLjI4OTEgMTEuMzU1IDEzLjI4OTEgMTAuOTk5NlYzLjI2NTI1QzEzLjI4OTEgMi45MDk4NSAxMy41NzgyIDIuNjIwNzIgMTMuOTMzNiAyLjYyMDcySDI1LjYyMTFDMjUuOTc2NSAyLjYyMDcyIDI2LjI2NTcgMi45MDk4NSAyNi4yNjU3IDMuMjY1MjVWMTAuOTk5NkMyNi4yNjU3IDExLjM1NSAyNS45NzY1IDExLjY0NDIgMjUuNjIxMSAxMS42NDQySDE5LjA4OTlDMTguOTY1MSAxMS42NDQyIDE4LjgzNjIgMTEuNjgyOCAxOC43MzA2IDExLjc1MzZaTTMyLjcxMSAxNi4xNTU5QzMyLjcxMSAxNi41MTEzIDMyLjQyMTggMTYuODAwNCAzMi4wNjY0IDE2LjgwMDRIMzAuNzc3NEMzMC40MjE0IDE2LjgwMDQgMzAuMTMyOCAxNy4wODkgMzAuMTMyOCAxNy40NDVWMTguODE4OEwyNy4yNjc3IDE2LjkwODdDMjcuMTYxOCAxNi44MzgxIDI3LjAzNzQgMTYuODAwNCAyNi45MTAyIDE2LjgwMDRIMjAuMzc4OUMyMC4wMjM1IDE2LjgwMDQgMTkuNzM0NCAxNi41MTEzIDE5LjczNDQgMTYuMTU1OVYxMi45MzMySDI1LjYyMTFDMjYuNjg3MyAxMi45MzMyIDI3LjU1NDcgMTIuMDY1OCAyNy41NTQ3IDEwLjk5OTZWNy43NzY5OEgzMi4wNjY0QzMyLjQyMTggNy43NzY5OCAzMi43MTEgOC4wNjYxMSAzMi43MTEgOC40MjE1MVYxNi4xNTU5WiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMjAuMzc4OSA3Ljc3Njk4SDE1LjIyMjdDMTQuODY2NyA3Ljc3Njk4IDE0LjU3ODEgOC4wNjU1NiAxNC41NzgxIDguNDIxNTFDMTQuNTc4MSA4Ljc3NzQ2IDE0Ljg2NjcgOS4wNjYwNCAxNS4yMjI3IDkuMDY2MDRIMjAuMzc4OUMyMC43MzQ5IDkuMDY2MDQgMjEuMDIzNCA4Ljc3NzQ2IDIxLjAyMzQgOC40MjE1MUMyMS4wMjM0IDguMDY1NTYgMjAuNzM0OSA3Ljc3Njk4IDIwLjM3ODkgNy43NzY5OFoiIGZpbGw9IndoaXRlIi8+PHBhdGggZD0iTTI0LjMzMjEgNS4xOTg4NEgxNS4yMjI3QzE0Ljg2NjcgNS4xOTg4NCAxNC41NzgxIDUuNDg3NDIgMTQuNTc4MSA1Ljg0MzM3QzE0LjU3ODEgNi4xOTkzMiAxNC44NjY3IDYuNDg3OSAxNS4yMjI3IDYuNDg3OUgyNC4zMzIxQzI0LjY4OCA2LjQ4NzkgMjQuOTc2NiA2LjE5OTMyIDI0Ljk3NjYgNS44NDMzN0MyNC45NzY2IDUuNDg3NDIgMjQuNjg4IDUuMTk4ODQgMjQuMzMyMSA1LjE5ODg0WiIgZmlsbD0id2hpdGUiLz48ZGVmcz48Y2xpcFBhdGggaWQ9ImNsaXAwIj48cmVjdCB4PSIyIiB5PSI4IiB3aWR0aD0iMjQiIGhlaWdodD0iMjMiIGZpbGw9IndoaXRlIi8+PC9jbGlwUGF0aD48L2RlZnM+PC9zdmc+");}.messengers-icon-btn {  position: relative;  display: inline-block;}.messengers-icon-btn .tooltiptext, .rngst_phone_body--tooltip .tooltiptext {   visibility: hidden;    position: absolute;    width: 120px;    background-color: #fff;    color: #424242;    font-size: 14px;    text-align: center;    font-family: "Open Sans", sans-serif;    font-style: normal;    padding: 5px 0;    border-radius: 6px;    z-index: 1;    opacity: 0;    transition: opacity 0.3s;    bottom: 11px;    right: 125%;    white-space: pre-wrap;}.rngst_phone_body--tooltip .tooltiptext {   width: 200px;}.messengers-icon-btn .tooltiptext::after, .rngst_phone_body--tooltip .tooltiptext::after {content: "";    position: absolute;    top: 50%;    left: 100%;    margin-top: -5px;    border-width: 5px;    border-style: solid;    border-color: transparent transparent transparent #fff;    white-space: normal;}.messengers-icon-btn:hover .tooltiptext, .rngst_phone_body--tooltip:hover .tooltiptext {  visibility: visible;  opacity: 1;}', a.append(i), checkMessengersSettings(e, o.old_data)) {
                    var s = document.createElement("div"), c = document.createElement("div"),
                        u = document.createElement("div"), M = document.createElement("div"),
                        g = document.createElement("div"), l = document.createElement("div"),
                        d = document.createElement("div"), N = document.createElement("div"),
                        y = o.language && "ru" === o.language || o.language && "uk" === o.language ? o.tooltipText[o.language] : o.tooltipText.en;
                    u.innerHTML = '<span class="tooltiptext">' + y + "</span>", s.appendChild(c), u.classList.add("rngst_phone_body--tooltip"), c.classList.add("dropbtn"), s.classList.add("rngst_phone_button"), s.classList.add("dropdownMessengers"), N.classList.add("rngst_phone_button_inner"), u.classList.add("rngst_phone_icon"), M.classList.add("rngst_phone_circle"), g.classList.add("rngst_phone_circle2"), l.classList.add("rngst_phone_fill"), d.classList.add("rngst_phone_body"), N.appendChild(u), N.appendChild(M), N.appendChild(g), N.appendChild(l), N.appendChild(d), o.button = N, o.icon = u, c.appendChild(N);
                    var D = document.createElement("div");
                    if (s.appendChild(D), D.classList.add("dropdown-content-rngst"), checkMessengersSettings(e, o.old_data, "telegram")) {
                        var I = document.createElement("a");
                        I.classList.add("messengers-icon-btn"), I.href = "https://telegram.me/" + e.userSettings.messengers.telegram.bot_name + "?start=u" + n.clientId.replace(/\./g, "-") + "vid" + state.pageViewId, I.target = "_blank", I.innerHTML = '<img alt="Telegram" class="messengers-icon messengers-icon-telegram" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMzAgMEMxMy40Mjk3IDAgMCAxMy40Mjk3IDAgMzBDMCA0Ni41NzAzIDEzLjQyOTcgNjAgMzAgNjBDNDYuNTcwMyA2MCA2MCA0Ni41NzAzIDYwIDMwQzYwIDEzLjQyOTcgNDYuNTcwMyAwIDMwIDBaIiBmaWxsPSIjMjlCNkY2Ii8+PHBhdGggZD0iTTQ0Ljc1ODMgMTYuNDkwN0wzOS4wOTggNDVDMzkuMDk4IDQ1IDM4Ljg1NiA0Ni4zMDQ0IDM3LjIyMTEgNDYuMzA0NEMzNi4zNDc1IDQ2LjMwNDQgMzUuODk4OSA0NS44OTY3IDM1Ljg5ODkgNDUuODk2N0wyMy42Mzk5IDM1Ljg1NzlMMTcuNjQzMSAzMi44NzY2TDkuOTQwNjIgMzAuODU2QzkuOTQwNjIgMzAuODU2IDguNTcxMjkgMzAuNDY1OCA4LjU3MTI5IDI5LjM0NzhDOC41NzEyOSAyOC40MTYyIDkuOTgxOTQgMjcuOTczNiA5Ljk4MTk0IDI3Ljk3MzZMNDIuMTkwOCAxNS4zNDk0QzQyLjE4NDkgMTUuMzQ5NCA0My4xNzA2IDE1IDQzLjg5MDcgMTVDNDQuMzMzMyAxNSA0NC44MzUgMTUuMTg2MyA0NC44MzUgMTUuNzQ1M0M0NC44MzUgMTYuMTE4IDQ0Ljc1ODMgMTYuNDkwNyA0NC43NTgzIDE2LjQ5MDdaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0yOC4zNTIgMzkuNjg2OEwyMy4yNTk5IDQ0LjgxNkMyMy4yNTk5IDQ0LjgxNiAyMy4wMzkyIDQ0Ljk4ODIgMjIuNzQzMSA0NS4wMDAxQzIyLjYzODYgNDUuMDAwMSAyMi41MjgzIDQ0Ljk4MjMgMjIuNDE4IDQ0LjkzNDhMMjMuODUyMSAzNS44Njk2TDI4LjM1MiAzOS42ODY4WiIgZmlsbD0iI0IwQkVDNSIvPjxwYXRoIGQ9Ik0zOC43NDg1IDIxLjE2NDFDMzguNDg5NCAyMC44MzMzIDM4LjAxODUgMjAuNzc0MiAzNy42ODg4IDIxLjAyMjNMMTcuODAxOCAzMi45NjY5QzE3LjgwMTggMzIuOTY2OSAyMC45NzUgNDEuODc1MSAyMS40NTc3IDQzLjQxNjlDMjEuOTQ2NCA0NC45NjQ2IDIyLjMzNDkgNDUuMDAwMSAyMi4zMzQ5IDQ1LjAwMDFMMjMuNzg5MSAzNS45Nzk2TDM4LjYwNzIgMjIuMjIxNUMzOC45MzY5IDIxLjk3MzQgMzguOTk1NyAyMS40OTQ5IDM4Ljc0ODUgMjEuMTY0MVoiIGZpbGw9IiNDRkQ4REMiLz48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIzMCIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMzAgMEMxMy40Mjk3IDAgMCAxMy40Mjk3IDAgMzBDMCA0Ni41NzAzIDEzLjQyOTcgNjAgMzAgNjBDNDYuNTcwMyA2MCA2MCA0Ni41NzAzIDYwIDMwQzYwIDEzLjQyOTcgNDYuNTcwMyAwIDMwIDBaIiBmaWxsPSIjMjlCNkY2Ii8+PHBhdGggZD0iTTQ0Ljc1ODMgMTYuNDkwN0wzOS4wOTggNDVDMzkuMDk4IDQ1IDM4Ljg1NiA0Ni4zMDQ0IDM3LjIyMTEgNDYuMzA0NEMzNi4zNDc1IDQ2LjMwNDQgMzUuODk4OSA0NS44OTY3IDM1Ljg5ODkgNDUuODk2N0wyMy42Mzk5IDM1Ljg1NzlMMTcuNjQzMSAzMi44NzY2TDkuOTQwNjIgMzAuODU2QzkuOTQwNjIgMzAuODU2IDguNTcxMjkgMzAuNDY1OCA4LjU3MTI5IDI5LjM0NzhDOC41NzEyOSAyOC40MTYyIDkuOTgxOTQgMjcuOTczNiA5Ljk4MTk0IDI3Ljk3MzZMNDIuMTkwOCAxNS4zNDk0QzQyLjE4NDkgMTUuMzQ5NCA0My4xNzA2IDE1IDQzLjg5MDcgMTVDNDQuMzMzMyAxNSA0NC44MzUgMTUuMTg2MyA0NC44MzUgMTUuNzQ1M0M0NC44MzUgMTYuMTE4IDQ0Ljc1ODMgMTYuNDkwNyA0NC43NTgzIDE2LjQ5MDdaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0yOC4zNTExIDM5LjY4NjhMMjMuMjU4OSA0NC44MTZDMjMuMjU4OSA0NC44MTYgMjMuMDM4MyA0NC45ODgyIDIyLjc0MjEgNDUuMDAwMUMyMi42Mzc2IDQ1LjAwMDEgMjIuNTI3MyA0NC45ODIzIDIyLjQxNyA0NC45MzQ4TDIzLjg1MTIgMzUuODY5NkwyOC4zNTExIDM5LjY4NjhaIiBmaWxsPSIjQjBCRUM1Ii8+PHBhdGggZD0iTTM4Ljc0OTQgMjEuMTY0MUMzOC40OTA0IDIwLjgzMzMgMzguMDE5NCAyMC43NzQyIDM3LjY4OTcgMjEuMDIyM0wxNy44MDI3IDMyLjk2NjlDMTcuODAyNyAzMi45NjY5IDIwLjk3NTkgNDEuODc1MSAyMS40NTg3IDQzLjQxNjlDMjEuOTQ3MyA0NC45NjQ2IDIyLjMzNTkgNDUuMDAwMSAyMi4zMzU5IDQ1LjAwMDFMMjMuNzkgMzUuOTc5NkwzOC42MDgyIDIyLjIyMTVDMzguOTM3OCAyMS45NzM0IDM4Ljk5NjcgMjEuNDk0OSAzOC43NDk0IDIxLjE2NDFaIiBmaWxsPSIjQ0ZEOERDIi8+PC9zdmc+" /><span class="tooltiptext">Telegram</span>', D.appendChild(I)
                    }
                    if (checkMessengersSettings(e, o.old_data, "viber")) {
                        var j = document.createElement("a");
                        j.classList.add("messengers-icon-btn"), j.href = "viber://pa?chatURI=" + e.userSettings.messengers.viber.bot_name + "&context=u" + n.clientId.replace(/\./g, "-") + "vid" + state.pageViewId, j.target = "_blank", j.innerHTML = '<img alt="Viber" class="messengers-icon messengers-icon-viber" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMCAzMEMwIDQ2LjU2ODUgMTMuNDMxNSA2MCAzMCA2MEM0Ni41Njg1IDYwIDYwIDQ2LjU2ODUgNjAgMzBDNjAgMTMuNDMxNSA0Ni41Njg1IDAgMzAgMEMxMy40MzE1IDAgMCAxMy40MzE1IDAgMzBaIiBmaWxsPSIjN0QzREFGIi8+PHBhdGggZD0iTTQ4Ljk3NTggMTkuMzQwNUw0OC45NjM5IDE5LjI5MzFDNDguMDA1NSAxNS40MTg1IDQzLjY4NDUgMTEuMjYwOCAzOS43MTY0IDEwLjM5NThMMzkuNjcxNiAxMC4zODY2QzMzLjI1MzMgOS4xNjIxNiAyNi43NDU1IDkuMTYyMTYgMjAuMzI4NiAxMC4zODY2TDIwLjI4MjUgMTAuMzk1OEMxNi4zMTU3IDExLjI2MDggMTEuOTk0NyAxNS40MTg1IDExLjAzNSAxOS4yOTMxTDExLjAyNDQgMTkuMzQwNUM5LjgzOTUxIDI0Ljc1MTYgOS44Mzk1MSAzMC4yMzkxIDExLjAyNDQgMzUuNjUwMkwxMS4wMzUgMzUuNjk3NUMxMS45NTM4IDM5LjQwNjggMTUuOTUzIDQzLjM3MzUgMTkuNzczIDQ0LjQ2NDRWNDguNzg5NkMxOS43NzMgNTAuMzU1IDIxLjY4MDcgNTEuMTIzOSAyMi43NjU2IDQ5Ljk5NDNMMjcuMTQ3OCA0NS40MzkxQzI4LjA5ODIgNDUuNDkyMyAyOS4wNDkxIDQ1LjUyMTkgMzAuMDAwMSA0NS41MjE5QzMzLjIzMDkgNDUuNTIxOSAzNi40NjMxIDQ1LjIxNjUgMzkuNjcxNiA0NC42MDQzTDM5LjcxNjQgNDQuNTk1QzQzLjY4NDUgNDMuNzMgNDguMDA1NSAzOS41NzIzIDQ4Ljk2MzkgMzUuNjk3N0w0OC45NzU4IDM1LjY1MDNDNTAuMTYwNyAzMC4yMzkxIDUwLjE2MDcgMjQuNzUxNiA0OC45NzU4IDE5LjM0MDVaTTQ1LjUwNzkgMzQuODY1NUM0NC44NjgxIDM3LjM5MzMgNDEuNTg3MiA0MC41MzU5IDM4Ljk4MDQgNDEuMTE2NUMzNS41Njc3IDQxLjc2NTUgMzIuMTI4MSA0Mi4wNDI5IDI4LjY5MTggNDEuOTQ3N0MyOC42MjM1IDQxLjk0NTggMjguNTU3OCA0MS45NzIzIDI4LjUxMDEgNDIuMDIxM0MyOC4wMjI1IDQyLjUyMTggMjUuMzEwNSA0NS4zMDU5IDI1LjMxMDUgNDUuMzA1OUwyMS45MDcyIDQ4Ljc5ODdDMjEuNjU4MyA0OS4wNTgxIDIxLjIyMTIgNDguODgxNiAyMS4yMjEyIDQ4LjUyMzVWNDEuMzU4NUMyMS4yMjEyIDQxLjI0MDIgMjEuMTM2NyA0MS4xMzk2IDIxLjAyMDUgNDEuMTE2OEMyMS4wMTk4IDQxLjExNjcgMjEuMDE5MSA0MS4xMTY1IDIxLjAxODUgNDEuMTE2NEMxOC40MTE3IDQwLjUzNTggMTUuMTMyMSAzNy4zOTMyIDE0LjQ5MDkgMzQuODY1M0MxMy40MjQ1IDI5Ljk3NDMgMTMuNDI0NSAyNS4wMTYxIDE0LjQ5MDkgMjAuMTI1MUMxNS4xMzIxIDE3LjU5NzMgMTguNDExNyAxNC40NTQ2IDIxLjAxODUgMTMuODc0QzI2Ljk3ODYgMTIuNzQwNSAzMy4wMjE2IDEyLjc0MDUgMzguOTgwNCAxMy44NzRDNDEuNTg4NSAxNC40NTQ2IDQ0Ljg2ODEgMTcuNTk3MyA0NS41MDc5IDIwLjEyNTFDNDYuNTc1NSAyNS4wMTYyIDQ2LjU3NTUgMjkuOTc0NCA0NS41MDc5IDM0Ljg2NTVaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0zNS42NzEgMzguMTcyOEMzNS4yNzAyIDM4LjA1MTEgMzQuODg4MyAzNy45Njk0IDM0LjUzMzYgMzcuODIyMkMzMC44NTgzIDM2LjI5NzMgMjcuNDc1NyAzNC4zMzAxIDI0Ljc5NjQgMzEuMzE0NUMyMy4yNzI3IDI5LjU5OTcgMjIuMDgwMiAyNy42NjM3IDIxLjA3MjEgMjUuNjE0OUMyMC41OTQgMjQuNjQzMiAyMC4xOTEyIDIzLjYzMzYgMTkuNzgwNSAyMi42MzA1QzE5LjQwNjEgMjEuNzE1NyAxOS45NTc2IDIwLjc3MDcgMjAuNTM4NCAyMC4wODE1QzIxLjA4MzMgMTkuNDM0NiAyMS43ODQ1IDE4LjkzOTYgMjIuNTQzOSAxOC41NzQ4QzIzLjEzNjYgMTguMjkgMjMuNzIxMyAxOC40NTQyIDI0LjE1NDIgMTguOTU2NkMyNS4wOSAyMC4wNDI4IDI1Ljk0OTYgMjEuMTg0NSAyNi42NDU3IDIyLjQ0MzVDMjcuMDczNyAyMy4yMTc5IDI2Ljk1NjIgMjQuMTY0NSAyNi4xODA1IDI0LjY5MTVDMjUuOTkyIDI0LjgxOTYgMjUuODIwMiAyNC45NyAyNS42NDQ1IDI1LjExNDdDMjUuNDkwNSAyNS4yNDE1IDI1LjM0NTUgMjUuMzY5NiAyNS4yNCAyNS41NDEzQzI1LjA0NjkgMjUuODU1NCAyNS4wMzc3IDI2LjIyNTkgMjUuMTYyIDI2LjU2NzRDMjYuMTE4NiAyOS4xOTYzIDI3LjczMSAzMS4yNDA1IDMwLjM3NzEgMzIuMzQxNkMzMC44MDA1IDMyLjUxNzcgMzEuMjI1NyAzMi43MjI5IDMxLjcxMzUgMzIuNjY2QzMyLjUzMDQgMzIuNTcwNSAzMi43OTQ5IDMxLjY3NDUgMzMuMzY3NCAzMS4yMDYzQzMzLjkyNjkgMzAuNzQ4OCAzNC42NDIgMzAuNzQyNyAzNS4yNDQ3IDMxLjEyNDJDMzUuODQ3NSAzMS41MDU3IDM2LjQzMiAzMS45MTUzIDM3LjAxMjggMzIuMzI5MkMzNy41ODMgMzIuNzM1NSAzOC4xNTA3IDMzLjEzMyAzOC42NzY3IDMzLjU5NjFDMzkuMTgyNCAzNC4wNDE1IDM5LjM1NjYgMzQuNjI1OCAzOS4wNzE4IDM1LjIzMDNDMzguNTUwNSAzNi4zMzcyIDM3Ljc5MTggMzcuMjU4MiAzNi42OTc1IDM3Ljg0NkMzNi4zODg1IDM4LjAxMTggMzYuMDE5NSAzOC4wNjU1IDM1LjY3MSAzOC4xNzI4QzM1LjI3MDIgMzguMDUxIDM2LjAxOTUgMzguMDY1NSAzNS42NzEgMzguMTcyOFoiIGZpbGw9IndoaXRlIi8+PHBhdGggZD0iTTMwLjAxMDMgMTcuMzA5MUMzNC44MTc3IDE3LjQ0MzggMzguNzY2MiAyMC42MzQyIDM5LjYxMjQgMjUuMzg3MUMzOS43NTY2IDI2LjE5NjkgMzkuODA3OSAyNy4wMjQ5IDM5Ljg3MiAyNy44NDY4QzM5Ljg5OSAyOC4xOTI1IDM5LjcwMzIgMjguNTIxIDM5LjMzMDEgMjguNTI1NUMzOC45NDQ4IDI4LjUzMDEgMzguNzcxNCAyOC4yMDc3IDM4Ljc0NjQgMjcuODYyMUMzOC42OTY5IDI3LjE3OCAzOC42NjI1IDI2LjQ5MDkgMzguNTY4MiAyNS44MTI0QzM4LjA3MDYgMjIuMjMxMiAzNS4yMTQ5IDE5LjI2ODQgMzEuNjUwMyAxOC42MzI3QzMxLjExNCAxOC41MzcgMzAuNTY1IDE4LjUxMTggMzAuMDIxNiAxOC40NTQ4QzI5LjY3ODEgMTguNDE4NyAyOS4yMjgyIDE4LjM5NzkgMjkuMTUyMSAxNy45NzFDMjkuMDg4MyAxNy42MTMgMjkuMzkwNCAxNy4zMjggMjkuNzMxMyAxNy4zMDk3QzI5LjgyNCAxNy4zMDQ1IDI5LjkxNzIgMTcuMzA4NyAzMC4wMTAzIDE3LjMwOTFDMzQuODE3NyAxNy40NDM4IDI5LjkxNzIgMTcuMzA4NyAzMC4wMTAzIDE3LjMwOTFaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0zNy4zMTYgMjYuNzhDMzcuMzA4MSAyNi44NCAzNy4zMDM5IDI2Ljk4MTEgMzcuMjY4NyAyNy4xMTQxQzM3LjE0MTEgMjcuNTk2OCAzNi40MDk0IDI3LjY1NzIgMzYuMjQwOSAyNy4xNzAxQzM2LjE5MSAyNy4wMjU1IDM2LjE4MzUgMjYuODYxMSAzNi4xODMyIDI2LjcwNTRDMzYuMTgxNSAyNS42ODcyIDM1Ljk2MDIgMjQuNjcgMzUuNDQ2NyAyMy43ODQxQzM0LjkxODkgMjIuODczNiAzNC4xMTI1IDIyLjEwODEgMzMuMTY2NyAyMS42NDVDMzIuNTk0OCAyMS4zNjQ5IDMxLjk3NjIgMjEuMTkwOSAzMS4zNDk0IDIxLjA4NzFDMzEuMDc1NSAyMS4wNDE4IDMwLjc5ODYgMjEuMDE0MyAzMC41MjMzIDIwLjk3NkMzMC4xODk3IDIwLjkyOTcgMzAuMDExNSAyMC43MTcgMzAuMDI3MyAyMC4zODgzQzMwLjA0MjEgMjAuMDgwMiAzMC4yNjcyIDE5Ljg1ODYgMzAuNjAyOSAxOS44Nzc2QzMxLjcwNjIgMTkuOTQwMyAzMi43NzE4IDIwLjE3ODcgMzMuNzUyNyAyMC42OTgxQzM1Ljc0NzMgMjEuNzU0NCAzNi44ODY2IDIzLjQyMTcgMzcuMjE5MiAyNS42NDhDMzcuMjM0MiAyNS43NDg4IDM3LjI1ODQgMjUuODQ4NyAzNy4yNjYxIDI1Ljk1QzM3LjI4NDkgMjYuMiAzNy4yOTY4IDI2LjQ1MDMgMzcuMzE2IDI2Ljc4QzM3LjMwODEgMjYuODQgMzcuMjk2OCAyNi40NTAzIDM3LjMxNiAyNi43OFoiIGZpbGw9IndoaXRlIi8+PHBhdGggZD0iTTM0LjMyNiAyNi42NjMyQzMzLjkyMzcgMjYuNjcwNCAzMy43MDg1IDI2LjQ0NzggMzMuNjY3IDI2LjA3OUMzMy42MzgyIDI1LjgyMTkgMzMuNjE1NCAyNS41NjE0IDMzLjU1NDEgMjUuMzExMkMzMy40MzMyIDI0LjgxODYgMzMuMTcxMyAyNC4zNjIgMzIuNzU2OSAyNC4wNjAxQzMyLjU2MTIgMjMuOTE3NSAzMi4zMzk1IDIzLjgxMzYgMzIuMTA3MyAyMy43NDY2QzMxLjgxMjIgMjMuNjYxNCAzMS41MDU5IDIzLjY4NDkgMzEuMjExNSAyMy42MTI3QzMwLjg5MTggMjMuNTM0NCAzMC43MTUgMjMuMjc1NSAzMC43NjUzIDIyLjk3NTZDMzAuODExIDIyLjcwMjcgMzEuMDc2NSAyMi40ODk3IDMxLjM3NDcgMjIuNTExM0MzMy4yMzg2IDIyLjY0NTggMzQuNTcwNyAyMy42MDk0IDM0Ljc2MDggMjUuODAzNkMzNC43NzQzIDI1Ljk1ODQgMzQuNzkwMSAyNi4xMjIxIDM0Ljc1NTcgMjYuMjcwMkMzNC42OTY4IDI2LjUyMzggMzQuNTA5MSAyNi42NTA4IDM0LjMyNiAyNi42NjMyQzMzLjkyMzcgMjYuNjcwNCAzNC41MDkxIDI2LjY1MDggMzQuMzI2IDI2LjY2MzJaIiBmaWxsPSJ3aGl0ZSIvPjxjaXJjbGUgY3g9IjMwIiBjeT0iMzAiIHI9IjMwIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0wIDMwQzAgNDYuNTY4NSAxMy40MzE1IDYwIDMwIDYwQzQ2LjU2ODUgNjAgNjAgNDYuNTY4NSA2MCAzMEM2MCAxMy40MzE1IDQ2LjU2ODUgMCAzMCAwQzEzLjQzMTUgMCAwIDEzLjQzMTUgMCAzMFoiIGZpbGw9IiM3RDNEQUYiLz48cGF0aCBkPSJNNDguOTc0OCAxOS4zNDA1TDQ4Ljk2MjkgMTkuMjkzMUM0OC4wMDQ1IDE1LjQxODUgNDMuNjgzNSAxMS4yNjA4IDM5LjcxNTQgMTAuMzk1OEwzOS42NzA2IDEwLjM4NjZDMzMuMjUyNCA5LjE2MjE2IDI2Ljc0NDYgOS4xNjIxNiAyMC4zMjc2IDEwLjM4NjZMMjAuMjgxNSAxMC4zOTU4QzE2LjMxNDcgMTEuMjYwOCAxMS45OTM4IDE1LjQxODUgMTEuMDM0IDE5LjI5MzFMMTEuMDIzNCAxOS4zNDA1QzkuODM4NTQgMjQuNzUxNiA5LjgzODU0IDMwLjIzOTEgMTEuMDIzNCAzNS42NTAyTDExLjAzNCAzNS42OTc1QzExLjk1MjggMzkuNDA2OCAxNS45NTIgNDMuMzczNSAxOS43NzIgNDQuNDY0NFY0OC43ODk2QzE5Ljc3MiA1MC4zNTUgMjEuNjc5NyA1MS4xMjM5IDIyLjc2NDYgNDkuOTk0M0wyNy4xNDY4IDQ1LjQzOTFDMjguMDk3MiA0NS40OTIzIDI5LjA0ODIgNDUuNTIxOSAyOS45OTkxIDQ1LjUyMTlDMzMuMjMgNDUuNTIxOSAzNi40NjIxIDQ1LjIxNjUgMzkuNjcwNiA0NC42MDQzTDM5LjcxNTQgNDQuNTk1QzQzLjY4MzUgNDMuNzMgNDguMDA0NSAzOS41NzIzIDQ4Ljk2MjkgMzUuNjk3N0w0OC45NzQ4IDM1LjY1MDNDNTAuMTU5NyAzMC4yMzkxIDUwLjE1OTcgMjQuNzUxNiA0OC45NzQ4IDE5LjM0MDVaTTQ1LjUwNyAzNC44NjU1QzQ0Ljg2NzEgMzcuMzkzMyA0MS41ODYyIDQwLjUzNTkgMzguOTc5NCA0MS4xMTY1QzM1LjU2NjcgNDEuNzY1NSAzMi4xMjcxIDQyLjA0MjkgMjguNjkwOCA0MS45NDc3QzI4LjYyMjUgNDEuOTQ1OCAyOC41NTY4IDQxLjk3MjMgMjguNTA5MiA0Mi4wMjEzQzI4LjAyMTUgNDIuNTIxOCAyNS4zMDk1IDQ1LjMwNTkgMjUuMzA5NSA0NS4zMDU5TDIxLjkwNjIgNDguNzk4N0MyMS42NTc0IDQ5LjA1ODEgMjEuMjIwMyA0OC44ODE2IDIxLjIyMDMgNDguNTIzNVY0MS4zNTg1QzIxLjIyMDMgNDEuMjQwMiAyMS4xMzU3IDQxLjEzOTYgMjEuMDE5NSA0MS4xMTY4QzIxLjAxODggNDEuMTE2NyAyMS4wMTgyIDQxLjExNjUgMjEuMDE3NSA0MS4xMTY0QzE4LjQxMDcgNDAuNTM1OCAxNS4xMzExIDM3LjM5MzIgMTQuNDkgMzQuODY1M0MxMy40MjM1IDI5Ljk3NDMgMTMuNDIzNSAyNS4wMTYxIDE0LjQ5IDIwLjEyNTFDMTUuMTMxMSAxNy41OTczIDE4LjQxMDcgMTQuNDU0NiAyMS4wMTc1IDEzLjg3NEMyNi45Nzc2IDEyLjc0MDUgMzMuMDIwNiAxMi43NDA1IDM4Ljk3OTQgMTMuODc0QzQxLjU4NzUgMTQuNDU0NiA0NC44NjcxIDE3LjU5NzMgNDUuNTA3IDIwLjEyNTFDNDYuNTc0NiAyNS4wMTYyIDQ2LjU3NDYgMjkuOTc0NCA0NS41MDcgMzQuODY1NVoiIGZpbGw9IndoaXRlIi8+PHBhdGggZD0iTTM1LjY3IDM4LjE3MjhDMzUuMjY5MiAzOC4wNTExIDM0Ljg4NzMgMzcuOTY5NCAzNC41MzI2IDM3LjgyMjJDMzAuODU3MyAzNi4yOTczIDI3LjQ3NDggMzQuMzMwMSAyNC43OTU0IDMxLjMxNDVDMjMuMjcxOCAyOS41OTk3IDIyLjA3OTIgMjcuNjYzNyAyMS4wNzExIDI1LjYxNDlDMjAuNTkzMSAyNC42NDMyIDIwLjE5MDIgMjMuNjMzNiAxOS43Nzk2IDIyLjYzMDVDMTkuNDA1MSAyMS43MTU3IDE5Ljk1NjYgMjAuNzcwNyAyMC41Mzc0IDIwLjA4MTVDMjEuMDgyMyAxOS40MzQ2IDIxLjc4MzUgMTguOTM5NiAyMi41NDI5IDE4LjU3NDhDMjMuMTM1NiAxOC4yOSAyMy43MjAzIDE4LjQ1NDIgMjQuMTUzMiAxOC45NTY2QzI1LjA4OSAyMC4wNDI4IDI1Ljk0ODYgMjEuMTg0NSAyNi42NDQ3IDIyLjQ0MzVDMjcuMDcyNyAyMy4yMTc5IDI2Ljk1NTMgMjQuMTY0NSAyNi4xNzk1IDI0LjY5MTVDMjUuOTkxIDI0LjgxOTYgMjUuODE5MiAyNC45NyAyNS42NDM2IDI1LjExNDdDMjUuNDg5NSAyNS4yNDE1IDI1LjM0NDYgMjUuMzY5NiAyNS4yMzkgMjUuNTQxM0MyNS4wNDYgMjUuODU1NCAyNS4wMzY4IDI2LjIyNTkgMjUuMTYxIDI2LjU2NzRDMjYuMTE3NyAyOS4xOTYzIDI3LjczMDEgMzEuMjQwNSAzMC4zNzYxIDMyLjM0MTZDMzAuNzk5NSAzMi41MTc3IDMxLjIyNDggMzIuNzIyOSAzMS43MTI1IDMyLjY2NkMzMi41Mjk1IDMyLjU3MDUgMzIuNzk0IDMxLjY3NDUgMzMuMzY2NCAzMS4yMDYzQzMzLjkyNiAzMC43NDg4IDM0LjY0MSAzMC43NDI3IDM1LjI0MzcgMzEuMTI0MkMzNS44NDY2IDMxLjUwNTcgMzYuNDMxIDMxLjkxNTMgMzcuMDExOSAzMi4zMjkyQzM3LjU4MjEgMzIuNzM1NSAzOC4xNDk4IDMzLjEzMyAzOC42NzU3IDMzLjU5NjFDMzkuMTgxNCAzNC4wNDE1IDM5LjM1NTYgMzQuNjI1OCAzOS4wNzA4IDM1LjIzMDNDMzguNTQ5NSAzNi4zMzcyIDM3Ljc5MDkgMzcuMjU4MiAzNi42OTY1IDM3Ljg0NkMzNi4zODc1IDM4LjAxMTggMzYuMDE4NSAzOC4wNjU1IDM1LjY3IDM4LjE3MjhDMzUuMjY5MiAzOC4wNTEgMzYuMDE4NSAzOC4wNjU1IDM1LjY3IDM4LjE3MjhaIiBmaWxsPSJ3aGl0ZSIvPjxwYXRoIGQ9Ik0zMC4wMDkzIDE3LjMwOTFDMzQuODE2OCAxNy40NDM4IDM4Ljc2NTMgMjAuNjM0MiAzOS42MTE0IDI1LjM4NzFDMzkuNzU1NiAyNi4xOTY5IDM5LjgwNjkgMjcuMDI0OSAzOS44NzExIDI3Ljg0NjhDMzkuODk4IDI4LjE5MjUgMzkuNzAyMyAyOC41MjEgMzkuMzI5MiAyOC41MjU1QzM4Ljk0MzggMjguNTMwMSAzOC43NzA0IDI4LjIwNzcgMzguNzQ1NCAyNy44NjIxQzM4LjY5NTkgMjcuMTc4IDM4LjY2MTUgMjYuNDkwOSAzOC41NjczIDI1LjgxMjRDMzguMDY5NiAyMi4yMzEyIDM1LjIxNCAxOS4yNjg0IDMxLjY0OTQgMTguNjMyN0MzMS4xMTMgMTguNTM3IDMwLjU2NCAxOC41MTE4IDMwLjAyMDYgMTguNDU0OEMyOS42NzcxIDE4LjQxODcgMjkuMjI3MyAxOC4zOTc5IDI5LjE1MTIgMTcuOTcxQzI5LjA4NzMgMTcuNjEzIDI5LjM4OTUgMTcuMzI4IDI5LjczMDMgMTcuMzA5N0MyOS44MjMgMTcuMzA0NSAyOS45MTYyIDE3LjMwODcgMzAuMDA5MyAxNy4zMDkxQzM0LjgxNjggMTcuNDQzOCAyOS45MTYyIDE3LjMwODcgMzAuMDA5MyAxNy4zMDkxWiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMzcuMzE1IDI2Ljc4QzM3LjMwNzEgMjYuODQgMzcuMzAyOSAyNi45ODExIDM3LjI2NzcgMjcuMTE0MUMzNy4xNDAyIDI3LjU5NjggMzYuNDA4NCAyNy42NTcyIDM2LjIzOTkgMjcuMTcwMUMzNi4xOSAyNy4wMjU1IDM2LjE4MjUgMjYuODYxMSAzNi4xODIyIDI2LjcwNTRDMzYuMTgwNSAyNS42ODcyIDM1Ljk1OTIgMjQuNjcgMzUuNDQ1NyAyMy43ODQxQzM0LjkxNzkgMjIuODczNiAzNC4xMTE1IDIyLjEwODEgMzMuMTY1NyAyMS42NDVDMzIuNTkzOCAyMS4zNjQ5IDMxLjk3NTMgMjEuMTkwOSAzMS4zNDg1IDIxLjA4NzFDMzEuMDc0NSAyMS4wNDE4IDMwLjc5NzYgMjEuMDE0MyAzMC41MjIzIDIwLjk3NkMzMC4xODg3IDIwLjkyOTcgMzAuMDEwNiAyMC43MTcgMzAuMDI2NCAyMC4zODgzQzMwLjA0MTEgMjAuMDgwMiAzMC4yNjYyIDE5Ljg1ODYgMzAuNjAyIDE5Ljg3NzZDMzEuNzA1MiAxOS45NDAzIDMyLjc3MDkgMjAuMTc4NyAzMy43NTE3IDIwLjY5ODFDMzUuNzQ2MyAyMS43NTQ0IDM2Ljg4NTcgMjMuNDIxNyAzNy4yMTgyIDI1LjY0OEMzNy4yMzMyIDI1Ljc0ODggMzcuMjU3NSAyNS44NDg3IDM3LjI2NTEgMjUuOTVDMzcuMjgzOSAyNi4yIDM3LjI5NTggMjYuNDUwMyAzNy4zMTUgMjYuNzhDMzcuMzA3MSAyNi44NCAzNy4yOTU4IDI2LjQ1MDMgMzcuMzE1IDI2Ljc4WiIgZmlsbD0id2hpdGUiLz48cGF0aCBkPSJNMzQuMzI1IDI2LjY2MzdDMzMuOTIyOCAyNi42NzA5IDMzLjcwNzUgMjYuNDQ4MyAzMy42NjYgMjYuMDc5NUMzMy42MzcyIDI1LjgyMjQgMzMuNjE0NCAyNS41NjE5IDMzLjU1MzEgMjUuMzExN0MzMy40MzIyIDI0LjgxOSAzMy4xNzA0IDI0LjM2MjUgMzIuNzU1OSAyNC4wNjA2QzMyLjU2MDMgMjMuOTE4IDMyLjMzODUgMjMuODE0MSAzMi4xMDYzIDIzLjc0NzFDMzEuODExMyAyMy42NjE5IDMxLjUwNDkgMjMuNjg1MyAzMS4yMTA1IDIzLjYxMzJDMzAuODkwOSAyMy41MzQ5IDMwLjcxNCAyMy4yNzYgMzAuNzY0MyAyMi45NzYxQzMwLjgxIDIyLjcwMzIgMzEuMDc1NiAyMi40OTAyIDMxLjM3MzggMjIuNTExOEMzMy4yMzc2IDIyLjY0NjMgMzQuNTY5NyAyMy42MDk5IDM0Ljc1OTggMjUuODA0MUMzNC43NzMzIDI1Ljk1ODkgMzQuNzg5MSAyNi4xMjI2IDM0Ljc1NDcgMjYuMjcwN0MzNC42OTU5IDI2LjUyNDMgMzQuNTA4MSAyNi42NTEzIDM0LjMyNSAyNi42NjM3QzMzLjkyMjggMjYuNjcwOSAzNC41MDgxIDI2LjY1MTMgMzQuMzI1IDI2LjY2MzdaIiBmaWxsPSJ3aGl0ZSIvPjwvc3ZnPg==" /><span class="tooltiptext">Viber</span>', D.appendChild(j)
                    }
                    if (checkMessengersSettings(e, o.old_data, "facebookMessenger")) {
                        var p = document.createElement("a");
                        p.classList.add("messengers-icon-btn"), p.href = "https://m.me/" + e.userSettings.messengers.facebookMessenger.bot_id + "?ref=u" + n.clientId.replace(/\./g, "-") + "vid" + state.pageViewId, p.target = "_blank", p.innerHTML = '<img alt="Messenger" class="messengers-icon messengers-icon-facebook" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMzAgMEMxMy40MzI1IDAgMCAxMi40MzUgMCAyNy43NzYzQzAgMzYuNTE3NSA0LjM2MTI1IDQ0LjMxMzggMTEuMTc4NyA0OS40MDYzVjYwTDIxLjM5MzcgNTQuMzkzOEMyNC4xMiA1NS4xNDc1IDI3LjAwNzUgNTUuNTU2MiAzMCA1NS41NTYyQzQ2LjU2NzUgNTUuNTU2MiA2MCA0My4xMjEzIDYwIDI3Ljc4QzYwIDEyLjQzNSA0Ni41Njc1IDAgMzAgMFoiIGZpbGw9IiMxRTg4RTUiLz48cGF0aCBkPSJNMzIuOTgxMiAzNy40MDY1TDI1LjM0MjUgMjkuMjU3OEwxMC40MzYyIDM3LjQwNjVMMjYuODMxMiAxOS45OTlMMzQuNjU3NSAyOC4xNDc4TDQ5LjM4IDE5Ljk5OUwzMi45ODEyIDM3LjQwNjVaIiBmaWxsPSIjRkFGQUZBIi8+PC9zdmc+" /><span class="tooltiptext">Messenger</span>', D.appendChild(p)
                    }
                    if (checkMessengersSettings(e, "all")) {
                        var f = document.createElement("button");
                        f.classList.add("messengers-icon-btn"), f.innerHTML = '<img alt="Close" class="messengers-icon messengers-icon-close" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjIiIGhlaWdodD0iNTgiIHZpZXdCb3g9IjAgMCA2MiA1OCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB4PSIxIiB3aWR0aD0iNjAiIGhlaWdodD0iNTcuNzM1OCIgcng9IjI4Ljg2NzkiIGZpbGw9IndoaXRlIi8+PHBhdGggZD0iTTMxLjQ3MjggMjkuNDk5OUwzNS43OTg0IDI1LjE3NDNDMzYuMDY3MiAyNC45MDU4IDM2LjA2NzIgMjQuNDcwMSAzNS43OTg0IDI0LjIwMTZDMzUuNTI5NyAyMy45MzI4IDM1LjA5NDUgMjMuOTMyOCAzNC44MjU3IDI0LjIwMTZMMzAuNTAwMSAyOC41MjcyTDI2LjE3NDMgMjQuMjAxNkMyNS45MDU1IDIzLjkzMjggMjUuNDcwMyAyMy45MzI4IDI1LjIwMTYgMjQuMjAxNkMyNC45MzI4IDI0LjQ3MDEgMjQuOTMyOCAyNC45MDU4IDI1LjIwMTYgMjUuMTc0M0wyOS41Mjc0IDI5LjQ5OTlMMjUuMjAxNiAzMy44MjU1QzI0LjkzMjggMzQuMDk0IDI0LjkzMjggMzQuNTI5NyAyNS4yMDE2IDM0Ljc5ODJDMjUuMzM1OSAzNC45MzI0IDI1LjUxMiAzNC45OTk1IDI1LjY4NzkgMzQuOTk5NUMyNS44NjM4IDM0Ljk5OTUgMjYuMDM5OSAzNC45MzI0IDI2LjE3NDMgMzQuNzk4TDMwLjUwMDEgMzAuNDcyNEwzNC44MjU3IDM0Ljc5OEMzNC45NjAxIDM0LjkzMjQgMzUuMTM2MiAzNC45OTk1IDM1LjMxMjEgMzQuOTk5NUMzNS40ODggMzQuOTk5NSAzNS42NjQxIDM0LjkzMjQgMzUuNzk4NCAzNC43OThDMzYuMDY3MiAzNC41Mjk1IDM2LjA2NzIgMzQuMDkzOCAzNS43OTg0IDMzLjgyNTNMMzEuNDcyOCAyOS40OTk5WiIgZmlsbD0iIzYzNjM2MyIvPjwvc3ZnPg==" />', D.appendChild(f)
                    }
                    if (document.body.insertAdjacentElement("beforeend", s), addEvents(o.icon, t, function (e) {
                        ("click" === e.type || "touchstart" === e.type || "mousedown" === e.type && !e.isTrusted) && document.getElementsByClassName("dropdownMessengers")[0].classList.add("dropdownMessengers-show")
                    }), checkMessengersSettings(e, o.old_data, "all")) {
                        addEvents(document, t, function (e) {
                            !1 === e.target.classList.contains("rngst_phone_icon") && document.getElementsByClassName("dropdownMessengers")[0].classList.remove("dropdownMessengers-show")
                        }), addEvents(document.getElementsByClassName("messengers-icon-close")[0], t, function (e) {
                            !1 === e.target.classList.contains("rngst_phone_icon") && document.getElementsByClassName("dropdownMessengers")[0].classList.remove("dropdownMessengers-show")
                        });
                        var m = document.getElementsByClassName("dropdown-content-rngst")[0];
                        void 0 !== m && addEvents(m, ["mousedown", "mouseup", "touchstart", "touchend", "keydown", "keyup", "click", "contextmenu", "dblclick"], function (e) {
                            e.stopPropagation()
                        })
                    }
                }
            },
            init: function () {
                if (o.old_data.ip_is_blocked || o.old_data.inactive_project || o.checkMessenger(), !o.old_data.is_working_time) return eraseCookie("rngst_callback", e.cookieDomain), void log("Out of working hours");
                if (e.callbackSettings.delay && (o.old_data.avg_time_to_call = +o.old_data.avg_time_to_call + e.callbackSettings.delay, createCookie("rngst_callback", o.old_data, 1800, e.cookieDomain)), o.old_data.language = o.language, !0 === o.old_data.is_callback_by_click && !e.callbackSettings.hideCallbackButton) {
                    if (checkMessengersSettings(e, o.old_data, "all") && void 0 !== document.getElementsByClassName("dropdown-content-rngst")[0]) {
                        var a = document.createElement("button");
                        a.classList.add("messengers-icon-btn"), a.classList.add("messengers-icon-btn--tel"), a.innerHTML = '<img alt="Telephone" class="messengers-icon messengers-icon-tel" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMzAgMEMxMy40Mjk3IDAgMCAxMy40Mjk3IDAgMzBDMCA0Ni41NzAzIDEzLjQyOTcgNjAgMzAgNjBDNDYuNTcwMyA2MCA2MCA0Ni41NzAzIDYwIDMwQzYwIDEzLjQyOTcgNDYuNTcwMyAwIDMwIDBaIiBmaWxsPSJ3aGl0ZSIvPjxjaXJjbGUgY3g9IjMwIiBjeT0iMzAiIHI9IjMwIiBmaWxsPSIjNENBRjUwIi8+PHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0yOC4xNTEgMzMuNTIzOEMyNC4wNjI3IDMwLjY0OTcgMjAuMDM0MiAyNy4yIDIxLjM0ODIgMjUuMzI4NUMyMy4yMzAzIDIyLjY0ODYgMjQuOTcyMyAyMC44OTY3IDIwLjA1NDggMTYuNTcyN0MxNS4xMzQ5IDEyLjI0OTIgMTMuMTE1NSAxNi41ODE4IDExLjI4OTQgMTkuMTc2NEM5LjE4NTUyIDIyLjE3MTggMTMuMjU2MSAzMS4yNTUzIDI0LjI5MDMgMzkuMDEyNUMzNS4zMjQgNDYuNzY3NSA0NS4yNTAxIDQ3LjUyNzcgNDcuMzU2MyA0NC41MzJDNDkuMTgyNCA0MS45Mzc1IDUyLjU3MzYgMzguNTcxMSA0Ni44Mzc3IDM1LjQwNTVDNDEuMTA2MyAzMi4yMzkzIDQwLjA0NzQgMzQuNDcxMyAzOC4xNjMxIDM3LjE1MTZDMzYuODQ4OCAzOS4wMjEgMzIuMjM5MiAzNi4zOTggMjguMTUxIDMzLjUyMzhaIiBmaWxsPSJ3aGl0ZSIgc3Ryb2tlPSJ3aGl0ZSIvPjwvc3ZnPg==" /><span class="tooltiptext">Callback</span>', document.getElementsByClassName("dropdown-content-rngst")[0].prepend(a), o.button = document.getElementsByClassName("rngst_phone_button")[0], o.icon = document.getElementsByClassName("rngst_phone_icon")[0]
                    } else document.body.insertAdjacentHTML("beforeend", '<div class="rngst_phone_button"><div class="rngst_phone_icon"></div><div class="rngst_phone_circle"></div><div class="rngst_phone_circle2"></div><div class="rngst_phone_fill"></div><div class="rngst_phone_body"></div></div>'), o.button = document.getElementsByClassName("rngst_phone_button")[0], o.icon = document.getElementsByClassName("rngst_phone_icon")[0];
                    checkMessengersSettings(e, o.old_data, "all") && addEvents(document.getElementsByClassName("messengers-icon-btn--tel")[0], t, function (t) {
                        if ("click" === t.type || "touchstart" === t.type || "mousedown" === t.type && !t.isTrusted) {
                            if ("undefined" !== e.userSettings.messengers) document.getElementsByClassName("dropdownMessengers")[0].classList.remove("dropdownMessengers-show");
                            o.old_data.form_type = "forced", o.button.style.display = "none", o.stopTimer(), o.callbackForm()
                        }
                    }), checkMessengersSettings(e, o.old_data, "all") && addEvents(document, t, function (e) {
                        document.getElementsByClassName("dropdownMessengers")[0].classList.remove("dropdownMessengers-show")
                    }), addEvents(o.icon, t, function (t) {
                        ("click" === t.type || "mousedown" === t.type && !t.isTrusted) && (checkMessengersSettings(e, o.old_data, "all") ? document.getElementsByClassName("dropdownMessengers")[0].classList.add("dropdownMessengers-show") : (o.old_data.form_type = "forced", o.button.style.display = "none", o.stopTimer(), o.callbackForm()))
                    }), addEvents(o.button, ["mousedown", "mouseup", "touchstart", "touchend", "keydown", "keyup", "click", "contextmenu", "dblclick"], function (e) {
                        e.stopPropagation()
                    })
                }
                e.callbackSettings.autoFormOffOnPage ? o.freezeTimer() : e.callbackSettings.autoFormOffOnPage ? o.stopTimer() : (!0 === o.old_data.is_callback_by_duration && r.init(o.old_data.avg_time_to_call, function () {
                    o.old_data.form_type = "default", null != o.button && (o.button.style.display = "none"), o.callbackForm()
                }), e.callbackSettings.autoFormOff && o.stopTimer(), o.old_data.recaptcha && !window.grecaptcha ? insertScriptElement("https://www.google.com/recaptcha/api.js?render=".concat(e.ringostatRecaptchaKey), function () {
                    var t = document.createElement("style");
                    t.innerHTML = ".grecaptcha-badge { visibility: hidden; }", document.getElementsByTagName("head")[0].append(t), grecaptcha.ready(function () {
                        grecaptcha.execute(e.ringostatRecaptchaKey, {action: "client_page"}).then(function (e) {
                            o.recaptcha_token = e
                        })
                    })
                }) : o.old_data.recaptcha && window.grecaptcha && (o.user_has_recaptcha = 1, console.log("Google reCaptcha script already loaded. Ringostat reCaptcha script skipped!")))
            },
            callbackForm: function () {
                a.sendPost("".concat(e.urls.substitution, "api/getCallbackForm/"), {
                    "data[ua_id]": n.uaId,
                    "data[form_type]": o.old_data.form_type,
                    "data[language]": o.old_data.language
                }, function () {
                    if (this.responseText) {
                        var t = document.createElement("iframe"), n = document.createElement("div");
                        t.src = "", t.title = "title", t.setAttribute("name", "name"), t.setAttribute("id", "id"), t.setAttribute("frameborder", "no"), (t.frameElement || t).style.cssText = "width: 100%; height: 100%; border: 0; display: block;", n.style.cssText = "width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 2147483646;", n.setAttribute("id", "wrapper_id"), n.appendChild(t);
                        var r = document.body.lastChild;
                        r.parentNode.insertBefore(n, r.nextSibling), o.iframeDocument = t.contentWindow.document, o.iframeDocument.write(this.responseText), o.iframeDocument.close();
                        var i = this.responseText.match(new RegExp('<span class="hide" id="rngst_form_design">(.*)</span>'))[1],
                            s = document.createElement("link");
                        s.rel = "stylesheet", s.type = "text/css", -1 === ["light", "kyivstar", "classic", "modern", "standard"].indexOf(i) ? s.href = "".concat(e.urls.backend, "callback/css/callback.css") : s.href = "".concat(e.urls.backend, "callback/css/callback_").concat(i, ".css?v.17122020");
                        var c = document.createElement("link");
                        c.id = "intlLink", c.rel = "stylesheet", c.type = "text/css", c.href = "".concat(e.urls.backend, "static/js/vendors/phone_input/v17/css/intlTelInput.css");
                        var u = document.createElement("script");
                        u.type = "text/javascript", u.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js", u.async = !1;
                        var M = document.createElement("script");
                        M.type = "text/javascript", M.src = "".concat(e.urls.backend, "static/js/vendors/phone_input/v17/js/intlTelInput.js"), M.async = !1;
                        var g = document.createElement("script");
                        g.type = "text/javascript", g.src = "".concat(e.urls.backend, "static/js/vendors/phone_input/v17/js/utils.js"), g.async = !1;
                        var l = document.createElement("script");
                        l.type = "text/javascript", l.text = 'var iti = intlTelInput(document.querySelector("#rngst_phone_input"), {\n                defaultCountry: "auto",\n                initialCountry: "auto",\n                placeholder: "agressive",\n                nationalMode: true,\n                autoHideDialCode: true,\n                formatOnDisplay: false,\n                preferredCountries: ["ua", "ru"],\n                geoIpLookup: function(callback) {\n                  $.get("'.concat(e.urls.api, 'ipinfo", function() {}, "json").always(function(resp) {\n                    var countryCode = (resp && resp.country) ? resp.country : "ua";\n                    callback(countryCode);\n                  })\n                },\n                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {\n                if(selectedCountryData.iso2 === "ua") {selectedCountryPlaceholder = "067 123 4567"}\n                  return selectedCountryPlaceholder;\n                },\n              });') + '$(window).trigger("load");$("#rngst_phone_input").keydown(function() {    $(".rngst_error_text").addClass("hide");});$("#rngst_send_callback").on("keypress click touchstart", function (e) {        e.preventDefault();        if (!(e.type === "keypress" && e.which !== 13)) {            if ($.trim($("#rngst_phone_input").val())) {                if (window.iti.isValidNumber() && $("#rngst_phone_input").val().search(/[a-zA-Zа-яА-Я]/) === -1) {                    var message = {                       num_to_call: iti.getNumber(),                       messageType: "transmitNumToCall",                       name: $("#rngst_name_field").val() || \'\'                    };                    $(".rngst__text--bottom").addClass("hide");                    parent.postMessage(message, "*");                } else {                    $(".rngst_error_text").removeClass("hide");                }            }        }    });const isMobile = (/iphone|ipod|android|ie|blackberry|fennec|nokia|opera mini|windows mobile|windows phone|iemobile/).test(navigator.userAgent.toLowerCase()) ? true : false;var callbackNumState = "";if(isMobile){   $("#rngst_modalDialog").addClass("rngst_modal--mobile");}if(document.getElementById("rngst_form_design").innerHTML === "modern" && isMobile){   $("body").css("overflow-y", "auto");$("body").css("display", "block");   $("#rngst_phone_input").prop("readonly", true);   $(".rngst_dialpad__item").click(function(){   $(this).addClass("animation-rngst");   setTimeout(function(){$(".rngst_dialpad__item").removeClass("animation-rngst");},100);       if($(this).hasClass("rngst_dialpad__delete")){         callbackNumState = callbackNumState.slice(0, -1);         iti.setNumber(callbackNumState);       }else{           var btnNumber = this.innerHTML;           var btnNumberString = btnNumber.toString();           callbackNumState = callbackNumState + btnNumberString;           iti.setNumber(callbackNumState);     }   })}';
                        var d = document.createElement("script");
                        d.type = "text/javascript", d.text = 'var spamModalPopup = document.querySelector(".spam_modal_popup");\nvar closeButton = document.querySelector(".spam_modal_popup_close_button");\nfunction toggleModal() {\n    spamModalPopup.classList.toggle("show_spam_modal_popup");\n}\nfunction windowOnClick(event) {\n    if (event.target === spamModalPopup) {\n        toggleModal();\n    }\n} closeButton.addEventListener("click", toggleModal);\nwindow.addEventListener("click", windowOnClick);', 1 === o.old_data.recaptcha && 0 === o.user_has_recaptcha && (d.text += "\n            var recaptchaPolicyWrapper = document.getElementById('recaptcha_policy');\n            if (recaptchaPolicyWrapper) {\n              recaptchaPolicyWrapper.style.display = 'block';\n            }\n            "), d.async = !1, l.async = !1, o.iframeDocument.head.appendChild(s), o.overlay = o.iframeDocument.body.firstElementChild, o.form = o.iframeDocument.body.lastElementChild, o.overlay.style.display = "none", o.form.style.display = "none", s.onload = function () {
                            o.overlay.style.display = "flex", o.form.style.display = "flex", a.fadeIn(o.overlay), a.fadeIn(o.form), o.callbackLog(1), o.iframeDocument.head.appendChild(c), o.iframeDocument.head.appendChild(u), u.onload = function () {
                                o.iframeDocument.head.appendChild(M)
                            }, M.onload = function () {
                                o.iframeDocument.head.appendChild(g), o.iframeDocument.head.appendChild(d), o.iframeDocument.head.appendChild(l)
                            }
                        }, addEvents(o.iframeDocument.getElementById("rngst_close"), ["mousedown", "touchstart", "keydown"], N), addEvents(o.iframeDocument.getElementById("rngst_overlay"), ["mousedown", "touchstart", "keydown"], N), addEvents(window, ["message"], o.initiateCall), log("getCallbackForm  Success : ".concat(this.status, " - ").concat(this.statusText))
                    }

                    function N() {
                        a.fadeOut(o.overlay), a.fadeOut(o.form, function () {
                            n && n.parentNode && n.parentNode.removeChild(n), void 0 !== e.callbackSettings.hideCallbackButton && !1 !== e.callbackSettings.hideCallbackButton || (o.button.style.display = "block")
                        }), o.callbackLog(0)
                    }
                }, function () {
                    log("getCallbackForm  Error : ".concat(this.status, " - ").concat(this.statusText))
                })
            },
            callbackLog: function (t) {
                var r = v4_1();
                a.sendPost("".concat(e.urls.analytics, "callback_form/v1"), {
                    "data[ua_id]": n.uaId,
                    "data[client_id]": n.clientId,
                    "data[avg_time_to_call]": o.old_data.avg_time_to_call,
                    "data[flag]": t,
                    "data[hid]": r,
                    "data[vid]": state.pageViewId
                }, function () {
                    sessionStorage.setItem("hit_id", r), log("callbackLog  Success : ".concat(this.status, " - ").concat(this.statusText))
                }, function () {
                    log("callbackLog  Error : ".concat(this.status, " - ").concat(this.statusText))
                })
            },
            setDisableStatusCallbackBtn: function (e) {
                o.iframeDocument.getElementById("rngst_send_callback").disabled = e, e ? o.iframeDocument.getElementById("rngst_send_callback").setAttribute("style", "opacity: 0.7; cursor: not-allowed;") : o.iframeDocument.getElementById("rngst_send_callback").setAttribute("style", "")
            },
            requestCallback: function (t, r) {
                return new Promise(function (i, s) {
                    var c = sessionStorage.getItem("hit_id");
                    if (null !== c) {
                        var u = {
                            "data[num_to_call]": t.num_to_call,
                            "data[ua_id]": n.uaId,
                            "data[client_id]": n.clientId,
                            "data[utmz]": readCookie(e.cookies.rngst2, !1) && readCookie(e.cookies.rngst2, !0).utmz || "",
                            "data[avg_time_to_call]": o.old_data.avg_time_to_call,
                            "data[page_url]": n.currentUrl,
                            "data[hid]": c
                        };
                        1 === o.user_has_recaptcha ? (u["data[recaptcha_token]"] = generateRandomString(255), u["data[verified_user]"] = 0) : o.recaptcha_token && 1 == o.old_data.recaptcha ? (u["data[recaptcha_token]"] = o.recaptcha_token, u["data[verified_user]"] = 1) : 1 == o.old_data.recaptcha ? (u["data[recaptcha_token]"] = generateRandomString(255), u["data[verified_user]"] = 1) : u["data[verified_user]"] = 1, a.sendPost("".concat(e.urls.substitution, "api/initiateCallback/"), u, function () {
                            if (200 === this.status) null !== r && r.e.target.submit(), i(); else if (403 === this.status) {
                                var e = this.response.length ? JSON.parse(this.response) : {};
                                if ("message" in e && "Callback is blocked for client because of spam" === e.message && o.iframeDocument) {
                                    var t = o.iframeDocument.getElementsByClassName("spam_modal_popup");
                                    t.length && (t[0].classList.toggle("show_spam_modal_popup"), o.setDisableStatusCallbackBtn(!1))
                                }
                                log("initiateCallback  403 Error : ".concat(this.status, " - ").concat(this.statusText)), s()
                            } else log("initiateCallback  Not success : ".concat(this.status, " - ").concat(this.statusText)), s();
                            document.addEventListener("DOMContentLoaded", function (e) {
                                o.setDisableStatusCallbackBtn(!1)
                            })
                        }, function () {
                            log("initiateCallback  Error : ".concat(this.status, " - ").concat(this.statusText)), s(), o.setDisableStatusCallbackBtn(!1)
                        })
                    } else log("initiateCallback  Error : hit_id not found in session storage"), s(), o.setDisableStatusCallbackBtn(!1)
                })
            },
            initiateCall: function (e) {
                var t = e.data;
                "transmitNumToCall" === t.messageType && (o.iframeDocument.getElementById("rngst_send_callback").disabled || (t.num_to_call = t.num_to_call.replace(/^(380|\+380)0/, "$1"), t.num_to_call = t.num_to_call.replace(/^(7|\+7)8/, "$1"), o.setDisableStatusCallbackBtn(!0), o.requestCallback(t, null).then(function () {
                    o.form.removeChild(o.iframeDocument.getElementById("rngst_callback_form")), a.addClass(o.iframeDocument.getElementsByClassName("rngst_before_text")[0], "hide"), a.addClass(o.iframeDocument.getElementsByClassName("rngst__header")[0], "hide"), a.removeClass(o.iframeDocument.getElementsByClassName("rngst_counter_text")[0], "hide"), a.removeClass(o.iframeDocument.getElementsByClassName("rngst_timer__wrapper")[0], "hide");
                    var e = 30, t = window.setInterval(function () {
                        o.iframeDocument.getElementById("rngst_timer").innerHTML = e.toFixed(2), e <= 0 && (o.iframeDocument.getElementById("rngst_timer").innerHTML = "", a.addClass(o.iframeDocument.getElementsByClassName("rngst_timer__wrapper")[0], "hide"), a.addClass(o.iframeDocument.getElementsByClassName("rngst_counter_text")[0], "hide"), a.removeClass(o.iframeDocument.getElementsByClassName("rngst_after_text")[0], "hide"), clearInterval(t)), e -= .01
                    }, 10);
                    addEvents(o.iframeDocument.getElementById("rngst_close"), ["mousedown", "touchstart", "keydown"], function () {
                        clearInterval(t)
                    }), addEvents(o.iframeDocument.getElementById("rngst_overlay"), ["mousedown", "touchstart", "keydown"], function () {
                        clearInterval(t)
                    }), o.setDisableStatusCallbackBtn(!1)
                }).catch(function () {
                    document.addEventListener("DOMContentLoaded", function (e) {
                        o.setDisableStatusCallbackBtn(!1)
                    })
                })))
            }
        }, i = {
            cookieLifeTime: 300,
            crossDomain: !1,
            linkedDomains: [""],
            numbers: {},
            callbackFunction: function () {
                log("default callbackFunction")
            },
            subDomain: !1,
            callbackSettings: {
                CallbackOffOnPage: !1,
                autoFormOffOnPage: !1,
                CallbackOff: !1,
                autoFormOff: !1,
                delay: 0
            },
            roistatTracking: !1,
            callbackFunctionBehavior: !1
        }, s = JSON.parse(JSON.stringify(i));
        e = a.deepExtend(s, e), log("config: ".concat(JSON.stringify(e, null, 2))), !0 !== e.userSettings.noGa ? window[e.ga](function () {
            n.uaId = e.uaId || window[e.ga].getAll()[0].get("trackingId"), n.clientId = window[e.ga].getAll()[0].get("clientId"), o.check()
        }) : (n.uaId = e.uaId, console.log(JSON.stringify(state)), n.clientId = state.clientId, o.check()), window.ringostatAPI = {}, window.ringostatAPI.setCallbackSettings = function (e) {
            o.setCallbackSettings(e)
        }, window.ringostatAPI.openCallbackForm = function () {
            o.old_data.form_type = "forced", o.stopTimer(), o.callbackForm()
        }, e.userSettings.customFormDataTracking.isActive && trackForms(e.userSettings, o)
    };
    bootstrap(has_1(config, "classified") && 1 === config.classified ? "classified" : "basic"), callback(config)
}();