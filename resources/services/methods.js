class Methods {
    static async validarCampos($this, arrayCampos) {
        //console.log('validarCampos', arrayCampos);
        for (let i = 0; i < arrayCampos.length; i++) {
            //console.log('campo', typeof $this.$refs[arrayCampos[i]], $this.$refs[arrayCampos[i]].$refs.input);
            if ($this.$refs[arrayCampos[i]].$refs.input) {
                let ref = $this.$refs[arrayCampos[i]];
                let campo = $this.$refs[arrayCampos[i]].$refs.input

                if (!campo.value && campo.required) {
                    campo.setCustomValidity(campo.validationMessage);
                    campo.focus();
                    if (campo.select)
                        campo.select();

                    return false;
                }

                if(campo.type == 'select-one'){

                }

                if(campo.type == 'number'){
                    const numeroMax = campo.max.indexOf(',') >= 0 ? parseFloat(campo.max) : parseInt(campo.max);
                    const numeroMin = campo.min.indexOf(',') >= 0 ? parseFloat(campo.min) : parseInt(campo.min);
                    const numerovalue = campo.value.indexOf(',') >= 0 ? parseFloat(campo.value) : parseInt(campo.value);

                    if(campo.max && numerovalue > numeroMax){
                        campo.setCustomValidity(campo.validationMessage);
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }else if(campo.min && numerovalue < numeroMin){
                        campo.setCustomValidity(campo.validationMessage);
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }
                }

                if (campo.type == 'password') {
                    if (campo.value.length < 8) {
                        campo.setCustomValidity('la password es menor a 8 caracteres');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }

                    const lowercaseCount = (campo.value.match(/[a-z]/g) || []).length;
                    const uppercaseCount = (campo.value.match(/[A-Z]/g) || []).length;
                    const numberCount = (campo.value.match(/[0-9]/g) || []).length;
                    const specialCharCount = (campo.value.match(/[^a-zA-Z0-9 ]/g) || []).length;
                    if (
                        lowercaseCount < 2 ||
                        uppercaseCount < 2 ||
                        numberCount < 2 ||
                        specialCharCount < 2
                    ) {
                        campo.setCustomValidity('la password debe tener 2 mayusculas, 2 minusculas, 2 numeros, 2 caracteres especiales no importa el orden');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }
                }

                if(campo.type == 'text' || campo.type == 'number' || campo.type == 'password'){
                    if(campo.value && campo.getAttribute('maxlength') && parseInt(campo.value.length) > parseInt(campo.getAttribute('maxlength'))){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en maximo de caracteres'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    } else if(campo.value && campo.getAttribute('minlength') && parseInt(campo.value.length) < parseInt(campo.getAttribute('minlength'))){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Error en minimo de caracteres'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }
                }

                if (campo.type == 'email' && campo.value) {
                    let validacion1 = '([a-zA-Z0-9]{1,50}[\\_\\-\\.]?[a-zA-Z0-9]{1,50}){1,100}';
                    let validacion2 = '[a-zA-Z]{2,5}$';
                    let cadena = '^'+ validacion1 +'@'+ validacion1 +'\\.'+ validacion2 +'';
                    let expreg = new RegExp(cadena);
                    if(!expreg.test(campo.value)){
                        campo.setCustomValidity((campo.validationMessage ? campo.validationMessage : 'Correo invalido'));
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }
                }

                if (ref.textarroba) {
                    if (!campo.value.includes('@')) {
                        campo.setCustomValidity('debe tener minimo un @');
                        campo.focus();
                        if (campo.select)
                            campo.select();

                        return false;
                    }
                }
            }else{
                console.log('no tiene type');
                console.log(arrayCampos[i], $this[arrayCampos[i]]);
                if (!$this[arrayCampos[i]]) {
                    return false;
                }
            }
        }

        return true;
    };
    static async armardatos($this, arrayCampos) {
        let data = {}
        arrayCampos.forEach(campo => {
            data[campo] = $this[campo]
        });
        return data;
    };
}
export { Methods };
