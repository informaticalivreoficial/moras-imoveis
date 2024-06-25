<template>
    <div class="contact-form contact-pad">
        <h3>Preencha o Formulário</h3>
        <form 
            @submit.prevent="sendContact"
            id="contact_form" 
            autocomplete="off"
        >
            <div class="row">
                <div class="col-12">                    
                    <div v-if="isBot" class="alert alert-danger">Você está praticando SPAM!</div>
                    <div v-else>
                        <div v-if="flash" class="alert alert-success">{{ flashMessage }}</div>
                    </div>
                </div>                                
                <!-- HONEYPOT -->
                <div class="hidden">                        
                        <input 
                        v-model="bot" 
                        name="bot-field"
                        />
                </div>                             
            </div>
            <div v-if="formHide" class="row">
                <div class="col-md-6">
                    <div class="form-group name">
                        <input 
                            type="text" 
                            name="nome" 
                            v-model="form.nome"
                            class="form-control" 
                            placeholder="Nome"
                        />
                        <span v-if="errorName" class="spanError">{{ errorName }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group email">
                        <input 
                            type="email" 
                            name="email" 
                            v-model="form.email"
                            class="form-control" 
                            placeholder="Email"
                        />
                        <span v-if="errorEmail" class="spanError">{{ errorEmail }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group subject">
                        <input 
                            type="text" 
                            name="assunto" 
                            v-model="form.assunto"
                            class="form-control" 
                            placeholder="Assunto"
                        />
                        <span v-if="errorAssunto" class="spanError">{{ errorAssunto }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group number">
                        <input 
                            type="text" 
                            name="telefone" 
                            v-model="form.telefone"
                            class="form-control telefonemask" 
                            placeholder="Telefone"
                        />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group message">
                        <textarea  
                            class="form-control" 
                            name="mensagem" 
                            v-model="form.mensagem"
                            placeholder="Mensagem"
                        ></textarea>
                        <span v-if="errorMensagem" class="spanError">{{ errorMensagem }}</span>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="send-btn text-center">
                        <button type="submit" class="button-md button-theme btn-3">{{ loading ? "Enviando Mensagem..." : "Enviar Agora" }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
                loading: false,
                flash: false,
                isBot: false,
                bot: null,
                formHide: true,
                flashMessage: '',
                errorName: '',
                errorEmail: '',
                errorAssunto: '',
                errorMensagem: ''
            };
        },
        methods: {
            sendContact(){
                this.loading = true;
                if(this.bot != null){
                    this.isBot = true;
                }
                else{                    
                    axios
                    .post('/sendEmail',{
                        nome: this.form.nome,
                        email: this.form.email,
                        assunto: this.form.assunto,
                        telefone: this.form.telefone,
                        mensagem: this.form.mensagem
                    })
                    .then(response => {
                        this.clearForm();
                        this.isBot = false;
                        this.flash = true;
                        this.flashMessage = response.data.sucess;
                        setTimeout(() => {this.formHide = false}, 3000);
                        //console.log(response);
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errorName = error.response.data['errorName'] ? error.response.data['errorName'] : '';
                            this.errorEmail = error.response.data['errorEmail'] ? error.response.data['errorEmail'] : '';
                            this.errorAssunto = error.response.data['errorAssunto'] ? error.response.data['errorAssunto'] : '';
                            this.errorMensagem = error.response.data['errorMensagem'] ? error.response.data['errorMensagem'] : '';                                                                                 
                        }
                        //console.log(error.response.data);                        
                    })
                    .finally(() => {
                        this.loading = false;
                    });
                }                
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

<style scoped>
    .spanError{
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
        color: #dc3545;
    }
    .hidden{
        display:none;
    }
</style>