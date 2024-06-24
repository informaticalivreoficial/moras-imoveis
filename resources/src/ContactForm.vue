<template>
    <h1>olá</h1>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    nome: "",
                    email: "",
                    assunto: "",
                    telefone: "",
                    mensagem: ""
                },
                flush: false
            };
        },
        methods: {
            sendContact(){
                axios
                    .post("",{
                        nome: this.form.nome,
                        email: this.form.email,
                        assunto: this.form.assunto,
                        telefone: this.form.telefone,
                        mensagem: this.form.mensagem
                    })
                    .then(res => {
                        this.flash = true
                        console.log(res);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            clearForm(){
                this.form.nome = '';
                this.form.email = '';
                this.form.assunto = '';
                this.form.telefone = '';
                this.form.mensagem = '';
            }
        },
    }
</script>