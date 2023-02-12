import { Controller } from '@hotwired/stimulus';
import * as bootstrap from 'bootstrap'

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller<HTMLDivElement> {
    connect() {
        //this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }

    hello() {
        alert('Hello world')
    }

    openModal() {
        const myModal = new bootstrap.Modal('#exampleModal')
        console.log(myModal)
        myModal.show()
    }
}
