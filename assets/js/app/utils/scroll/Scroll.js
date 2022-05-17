export default class Scroll {

    callbacks = {};

    constructor() {
        window.onscroll = (e) => {
            if (this.callbacks.when_reach_bottom_callback && this.endPosition() === this.currentPosition()) {
                this.callbacks.when_reach_bottom_callback();
            }
            if (this.callbacks.on_scroll_callback) {
                this.callbacks.on_scroll_callback(this.currentPosition());
            }
        }
    }

    onScroll(callback) {
        this.callbacks.on_scroll_callback = callback;
    }

    whenReachBottom(callback) {
        this.callbacks.when_reach_bottom_callback = callback;
    }

    currentPosition() {
        return window.scrollY;
    }

    endPosition() {
        return document.body.clientHeight - window.innerHeight;
    }
}