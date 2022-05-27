"use strict";

import {LitElement, html, css} from "https://cdn.jsdelivr.net/gh/lit/dist@2/core/lit-core.min.js";

class CustomInput extends LitElement {
  static formAssociated = true;

  firstUpdated(...args) {
    super.firstUpdated(...args);
    
    this._inputElem = this.shadowRoot.querySelector("input");
    this._inputElem.value = this.value;

    this.internals.setFormValue(this.value);
    this._testValidity();
  }
  
  get pattern() {return this._pattern;}
  set pattern(v) {this._pattern = new RegExp(v);}

  get confirmation() {return this._confirmation;}
  set confirmation(v) {
    this._confirmation = v;
    if (this._confirmation !== null) {
      this._confirmationTo = document.getElementById(v);
    }
  }

  static properties = {
    label: {},
    "input-type": {},
    name: {reflect: true},
    required: {type: Boolean, reflect: true},
    value: {reflect: true},
    validation: {},
    placeholder: {},
    pattern: {reflect: true},
    confirmation: {reflect: true}
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
    this["input-type"] = "text";
    this.required = false;
    this.value = "";
    this.placeholder = "";
    this.confirmation = null;

    this._pattern = null;

    this.internals = this.attachInternals();
  }

  _handleInput(e) {
    this.value = e.target.value;
    this.internals.setFormValue(this.value);
    this._testValidity();
  }

  _testValidity() {
    if (this.value.trim() === "") {
      if (!this.required) {
        this.internals.setValidity({});
      }
      else {
        this.internals.setValidity({valueMissing: true}, "Este campo é obrigatório", this._inputElem);
      }
    }
    else if (this._pattern !== null && !this._pattern.test(this.value)) {
      this.internals.setValidity({patternMismatch: true}, "Valor inválido", this._inputElem);
    }
    else if (this._confirmation !== null && this.value !== this._confirmationTo.value) {
      this.internals.setValidity({customError: true}, "Os valores não são iguais", this._inputElem);
    }
    else {
      this.internals.setValidity({});
    }
  }

  render() {
    return html`
      <label>${this.label}</label>
      <input type="${this["input-type"]}" @input=${this._handleInput} placeholder="${this.placeholder}"></input>
    `;
  }
}

customElements.define('custom-input', CustomInput);