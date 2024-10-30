(function (window, croct) {
    const wpCroct = {
        init() {
            const appId = wpCroct.getConfig('appId');

            if (appId === null) {
                return;
            }

            croct.plug({
                appId: appId,
                debug: wpCroct.getConfig('debug') === 'true'
            });

            wpCroct.registerInterestsTracking()
            wpCroct.applyPersonalization();
        },

        applyPersonalization() {
            document.querySelectorAll('[data-croct-value]').forEach(element => {
                croct.evaluate(element.getAttribute('data-croct-value'))
                    .then(result => {
                        if (result !== null && result !== '') {
                            element.outerHTML = result;
                        } else {
                            element.outerHTML = element.innerHTML;
                        }
                    })
                    .catch(() => {
                        element.outerHTML = element.innerHTML;
                    });
            });

            document.querySelectorAll('[data-croct-condition]').forEach(element => {
                croct.test(element.getAttribute('data-croct-condition'))
                    .then(result => {
                        if (result) {
                            element.outerHTML = element.getAttribute('data-croct-content');
                        } else {
                            element.parentNode.removeChild(element);
                        }
                    })
                    .catch(() => {
                        element.parentNode.removeChild(element);
                    });
            });
        },

        registerInterestsTracking() {
            const config = wpCroct.getConfig('interests');

            if (config === null) {
                return;
            }

            const [trigger, interests] = config.split(';');

            if (trigger && interests) {
                wpCroct.trackInterests(trigger, interests.split(','))
            }
        },

        trackInterests(trigger, interests) {
            const track = () => {
                croct.user.edit()
                    .combine('interests', interests)
                    .save();
            };

            switch (trigger) {
                case 'stay':
                    window.setTimeout(track, 10000);
                    break;

                case 'scroll':
                    const scrollListener = () => {
                        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight * 0.7) {
                            window.removeEventListener('scroll', scrollListener);
                            track();
                        }
                    };

                    window.addEventListener('scroll', scrollListener);
                    break;

                default:
                case 'visit':
                    track();
                    break;
            }
        },

        getConfig: (name) => {
            const tag = document.querySelector('meta[name="croct:' + name + '"]');

            if (tag === null || !tag.content) {
                return null;
            }

            return tag.content;
        },
    };

    if (document.readyState === "complete"
        || document.readyState === "loaded"
        || document.readyState === "interactive") {
        wpCroct.init();
    } else {
        window.addEventListener('DOMContentLoaded', wpCroct.init);
    }

})(window, croct);