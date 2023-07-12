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

    //optiene el valor que se va a fitrar en raiz EJ: persona.nombre
    getValue(data, raiz){
        if (raiz.indexOf('.') != -1) {
            let rutas = raiz.split('.');
            let aux = data;
            for (const index in rutas) {
                let ruta = rutas[index];
                if (aux[ruta]) {
                    aux = aux[ruta];
                } else {
                    let auxArray = [];
                    let arrayString = '';
                    for (const e in aux) {
                        if (aux[e][ruta] && typeof aux[e][ruta] === 'object') {
                            auxArray.push(aux[e][ruta]);
                        }else{
                            arrayString += aux[e][ruta] + ', ';
                        }
                    }

                    if (arrayString != '') {
                        aux = arrayString.slice(0, -2);
                    } else {
                        aux = auxArray;
                    }
                }
            }

            return aux;
        } else {
            if (datos[key][i] || datos[key][i] == 0 || datos[key][i] === false) {
                return datos[key][i];
            } else {
                console.log('error' + i, datos[key], cabecera[i]);
            }
        }
    }

    getData(datos, cabecera) {
        let array = [];
        if (typeof datos === 'object' || Array.isArray(datos)) {
            for (const key in datos) {
                let dataReturn = {};
                if (datos.hasOwnProperty(key)) {
                    for (const i in cabecera) {
                        if (key == 0) {
                            dataReturn[cabecera[i]] = null;
                        }

                        if (i.indexOf('.') != -1) {
                            let rutas = i.split('.');
                            let aux = datos[key]
                            for (const index in rutas) {
                                let ruta = rutas[index];
                                if (aux[ruta]) {
                                    aux = aux[ruta];
                                } else {
                                    let auxArray = [];
                                    let arrayString = '';
                                    for (const e in aux) {
                                        if (aux[e][ruta] && typeof aux[e][ruta] === 'object') {
                                            auxArray.push(aux[e][ruta]);
                                        }else{
                                            arrayString += aux[e][ruta] + ', ';
                                        }
                                    }

                                    if (arrayString != '') {
                                        aux = arrayString.slice(0, -2);
                                    } else {
                                        aux = auxArray;
                                    }
                                }
                            }

                            dataReturn[cabecera[i]] = aux;
                        } else {
                            if (datos[key][i] || datos[key][i] == 0 || datos[key][i] === false) {
                                dataReturn[cabecera[i]] = datos[key][i];
                            } else {
                                console.log('error' + i, datos[key], cabecera[i]);
                            }
                        }
                    }

                    array.push(dataReturn);
                }
            }
        }

        //console.log(array);
        return array;
    }

    obtenerFechaActual() {
        let fecha = new Date();

        let dia = fecha.getDate();
        let mes = fecha.getMonth() + 1; // Los meses van de 0 a 11
        let anio = fecha.getFullYear();

        let horas = fecha.getHours();
        let minutos = fecha.getMinutes();
        let segundos = fecha.getSeconds();

        dia = (dia < 10) ? '0' + dia : dia;
        mes = (mes < 10) ? '0' + mes : mes;
        horas = (horas < 10) ? '0' + horas : horas;
        minutos = (minutos < 10) ? '0' + minutos : minutos;
        segundos = (segundos < 10) ? '0' + segundos : segundos;

        const formatoFecha = dia + '/' + mes + '/' + anio;
        const formatoHora = horas + ':' + minutos + ':' + segundos;

        return formatoFecha + ' ' + formatoHora;
    }

    getTableHtml(datos, cabecera) {
        if (!cabecera || !datos) {
            return 'Error: Los argumentos no son válidos.';
        }

        if (typeof datos === 'object' || Array.isArray(datos)) {
            let tableHeaderContent = '';
            let tableContent = '';
            let title = 'titulo';
            let date = this.obtenerFechaActual();
            for (const key in datos) {
                tableContent += '<tr>';

                if (datos.hasOwnProperty(key)) {
                    for (const i in cabecera) {
                        if (key == 0) {
                            tableHeaderContent += '<th><h4>'+ cabecera[i] +'</h4></th>';
                        }

                        if (i.indexOf('.') != -1) {
                            let rutas = i.split('.');
                            let aux = datos[key]
                            for (const index in rutas) {
                                let ruta = rutas[index];
                                if (aux[ruta]) {
                                    aux = aux[ruta];
                                } else {
                                    let auxArray = [];
                                    let arrayString = '';
                                    for (const e in aux) {
                                        if (aux[e][ruta] && typeof aux[e][ruta] === 'object') {
                                            auxArray.push(aux[e][ruta]);
                                        }else{
                                            arrayString += aux[e][ruta] + ', ';
                                        }
                                    }

                                    if (arrayString != '') {
                                        aux = arrayString.slice(0, -2);
                                    } else {
                                        aux = auxArray;
                                    }
                                }
                            }

                            tableContent += '<td>'+ aux +'</td>';
                        } else {
                            if (datos[key][i] || datos[key][i] == 0 || datos[key][i] === false) {
                                tableContent += '<td>'+ datos[key][i] +'</td>';
                            } else {
                                console.log('error' + i, datos[key], cabecera[i]);
                            }
                        }
                    }
                }

                tableContent += '</tr>';
            }

            if (tableContent == '') {
                tableContent = '<td colspan="7">No se encontraron datos</td>';
            }

            return `<h3>`+ title +`</h3>
                    <table border="0" align="left" id="descuento">
                        <thead>
                            <tr>
                                `+ tableHeaderContent +`
                            </tr>
                        </thead>
                        <tbody>
                            `+ tableContent +`
                        </tbody>
                    </table>
                    <footer>
                        <p>generado: `+ date +`</p>
                    </footer>`;
        } else {
            return 'Error: Los datos no son un objeto o una matriz.';
        }
    }
}
export { Methods };
