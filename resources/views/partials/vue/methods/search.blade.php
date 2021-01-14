focusInput() { this.$refs.searchbox.focus(); },
showsearchinput(){ this.showingsearchinput = !this.showingsearchinput;
Vue.nextTick(() => { this.focusInput(); });
}
