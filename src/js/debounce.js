"use strict";

export class Debouncer {
  constructor(func, delay) {
    this.func = func;
    this.delay = delay;
    this.instanceId = 0;
  }
  getInvoker() {
    return () => this.func();
  }
  invoke() {
    clearTimeout(this.instanceId);
    this.instanceId = setTimeout(this.func, this.delay);
  }
}