const __SESSION__ = {
    store_session(obj) {
        if (typeof obj === 'object') {
            localStorage.setItem('session_expiration_date', obj.session_expiration)
            delete obj.session_expiration;
            localStorage.setItem('session', JSON.stringify(obj));
        }
    }
};

const __EVENT__ = {
    catch_event(event, callback) {
        if (typeof Object.keys(this.$event._events)[event] === 'undefined') {
            this.$event.$on(event, function (val) {
                callback(val);
            });
        }
    },
    emit_event(event, params) {
        this.$event.$emit(event, params);
    }
};

const __REQUEST__ = {
    __request(_obj) {
        if (typeof _obj.data === 'undefined') {
            _obj.data = {}
        }
        if (typeof _obj.headers === 'undefined') {
            _obj.headers = {}
        }
        axios({
            method: _obj.method,
            url: _obj.url,
            data: _obj.data,
            headers: _obj.headers
        })
        .then(_obj.then)
        .catch(err => {
            if (typeof _obj.catch !== 'undefined') {
                _obj.catch(err);
            } else {
                console.error(err);
            }
        });
    },
    ajax_get(url, _obj) {
        __REQUEST__.ajax_req(url, _obj, "GET");
    },
    ajax_post(url, _obj) {
        __REQUEST__.ajax_req(url, _obj, "POST");
    },
    ajax_put(url, _obj) {
        __REQUEST__.ajax_req(url, _obj, "PUT");
    },
    ajax_delete(url, _obj) {
        __REQUEST__.ajax_req(url, _obj, "DELETE");
    },
    ajax_req(url, _obj, _method) {
        _obj.url = url;
        _obj.method = _method;
        __REQUEST__.__request(_obj);
    }
};

const __METHODS__ = {
    methods: {
        redirect(url) {
            this.$route.push(url);
        }
    }
};

const __HELPER_METHODS__ = Object.assign({}, __EVENT__, __SESSION__, __REQUEST__);

export const Helpers = {
    methods: __HELPER_METHODS__
};
