"use strict";

import {LitElement, html, css} from "https://cdn.jsdelivr.net/gh/lit/dist@2/core/lit-core.min.js";

class CustomInput extends LitElement {
  static formAssociated = true;

  firstUpdated(...args) {
    super.firstUpdated(...args);
    this.internals.setFormValue(this.value);
    this._testValidity();
  }
  
  static properties = {
    label: {type: String},
    "input-type": {type: String},
    name: { type: String, reflect: true },
    required: {type: Boolean, reflect: true},
    value: {type: String},
    pattern: {type: String}
  };

  static styles = css`
    :host {
      position: relative;
      background-color: white;
      box-sizing: border-box;
    }
    input {
      box-sizing: border-box;
      width: 100%;
      height: 100%;
      padding: 0 10px;
      border-radius: inherit;
      border: none;
    }
    label {
      position: absolute;
      top: -10px;
      left: 5px;
      overflow: visible;
      padding: 0 5px;
    }
    input, label {
      background-color: inherit;
      font-family: inherit;
      font-size: inherit;
    }
  `;

  constructor() {
    super();
    this.label = "";
    this.value = "";
    this["input-type"] = "text";
    this.internals = this.attachInternals();
    this.required = false;
    this.pattern = "%+a";
  }

  _handleInput(e) {
    this.value = e.target.value;
    this.internals.setFormValue(this.value);
    this._testValidity();
  }

  _handleFocus(e) {
    
  }

  _testValidity() {
    const inputElem = this.shadowRoot.querySelector("input");

    if (this.required) {
      this.internals.setValidity({
        valueMissing: true
      }, 'This field is required', inputElem);
    }
    else {
      this.internals.setValidity({});
    }
  }

  render() {
    return html`
      <label>${this.label}</label>
    `;
  }
}

customElements.define('custom-input', CustomInput);