export class Validador {
    _campos = []
    constructor(campos = []) {
        for (const i in campos) {
            let campo = campos[i]
            let campoInput = document.getElementById(campo);
            if (!campoInput.id) {
                console.warn('el campo necesita un id para funcionar');
                return
            }

            campoInput.setAttribute('type', campoInput.getAttribute('type') ? campoInput.getAttribute('type') : campoInput.type);

            let campoMascara = campoInput.cloneNode(true);
            let type = campoMascara.getAttribute('type')
            if (type != 'radio') {
                this._campos.push(campoMascara);
            } else {
                this._campos['radio'] = {
                    type: 'radio',
                    id: campoMascara.id,
                    name: campoMascara.id,
                    value: 'on',
                    required: campoMascara.required
                };
            }

            if (campoInput.getAttribute('type') == 'numeric') {
                campoInput.addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                })
            }
        }
        console.log(this._campos);
    }

    tieneLabel(input) {
        let nombre = document.querySelector('[for="'+input.id+'"]')
        if (!nombre) {
            console.warn('el input deberia tener un label con atributo for');
            return false
        }
        return nombre;
    }

    validarCampos() {
        console.log(this._campos);
        for (const i in this._campos) {
            let input = this._campos[i];
            if (!input.id) {
                console.warn('el campo necesita un id para funcionar');
                return
            }

            let campo = document.getElementById(input.id);
            if (input.required) {
                console.log('valor', campo.value, input.getAttribute('type'));
                if (campo.value) {
                    switch (input.getAttribute('type')) {
                        case 'text':
                        case 'numeric':
                            if (input.maxLength && parseInt(input.maxLength) > 0) {
                                console.log(input.maxLength, 'maxLength', campo.value.length);
                                if (campo.value.length > parseInt(input.maxLength)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe tener menos de '+ input.maxLength +' caracteres', id: input.id}
                                }
                            }

                            if (input.minLength && parseInt(input.minLength) > 0) {
                                console.log(input.minLength, 'minLength', campo.value.length);
                                if (campo.value.length < parseInt(input.minLength)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe tener mas de '+ input.minLength +' caracteres', id: input.id}
                                }
                            }

                            if (input.max && parseInt(input.max) > 0) {
                                console.log(input.max, 'max', campo.value.length);
                                if (parseInt(campo.value) > parseInt(input.max)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe ser menor a '+ input.max, id: input.id}
                                }
                            }

                            if (input.min && parseInt(input.min) > 0) {
                                console.log(input.min, 'min', campo.value.length);
                                if (parseInt(campo.value) < parseInt(input.min)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe ser mayor a '+ input.min, id: input.id}
                                }
                            }
                            break;

                        case 'number':
                            if (input.max && parseInt(input.max) > 0) {
                                console.log(input.max, 'max', campo.value.length);
                                if (parseInt(campo.value) > parseInt(input.max)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe ser menor a '+ input.max, id: input.id}
                                }
                            }

                            if (input.min && parseInt(input.min) > 0) {
                                console.log(input.min, 'min', campo.value.length);
                                if (parseInt(campo.value) < parseInt(input.min)) {
                                    let nombre = this.tieneLabel(input);
                                    if (!nombre) {
                                        return
                                    }
                                    document.getElementById(input.id).focus();
                                    return {msg: 'El campo '+ nombre.textContent + ' debe ser mayor a '+ input.min, id: input.id}
                                }
                            }

                            break;

                        case 'select-one':
                            console.log(campo.value, 'select-one');
                            break;

                        case 'checkbox':
                            console.log(campo.checked);
                            if (!campo.checked) {
                                let nombre = this.tieneLabel(input);
                                if (!nombre) {
                                    return
                                }
                                document.getElementById(input.id).focus();
                                return {msg: 'El campo checkbox '+ nombre.textContent + ' es requerido', id: input.id}
                            }
                            break;

                        case 'radio':
                            console.log(campo);
                            if (!document.querySelector('[name="'+input.id+'"]:checked')) {
                                let nombre = this.tieneLabel(input);
                                if (!nombre) {
                                    return
                                }
                                document.getElementById(input.id).focus();
                                return {msg: 'El campo '+ nombre.textContent + ' es requerido', id: input.id}
                            }

                            break;

                        default:
                            console.warn('no esta definido el tipo del campo');
                            break;
                    }
                } else {
                    let nombre = this.tieneLabel(input);
                    if (!nombre) {
                        return
                    }
                    document.getElementById(input.id).focus();
                    return {msg: 'El campo '+ nombre.textContent + ' es requerido y está vacío', id: input.id}
                }
            }
        }

        return true;
    }
}
