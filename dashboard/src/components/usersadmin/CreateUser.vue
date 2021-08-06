<template>
    <panel ref="panelRegister" title="Creación de usuarios">
        <b-container>
            <b-row class="m-t-10 m-b-10">
                <b-col md="10" offset-md="1">
                    <b-form-group
                        class="row"
                        label="Nombre"
                        label-cols-md="3"
                        label-for="user-name"
                    >
                        <b-form-input
                            id="user-name"
                            v-model="newUser.name"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Apellido"
                        label-cols-md="3"
                        label-for="user-lastname"
                    >
                        <b-form-input
                            id="user-lastname"
                            v-model="newUser.lastname"
                            required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Email"
                        label-cols-md="3"
                        label-for="user-email"
                    >
                        <b-form-input
                            id="user-email"
                            v-model="newUser.email"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Rol"
                        label-cols-md="3"
                        label-for="user-rol"
                    >
                        <v-select
                            label="name"
                            :options="roles"
                            :placeholder="'Seleccione un rol'"
                            id="user-rol"
                            :clear-search-on-select="false"
                            :filterable="false"
                            @input="selectRol"
                        ></v-select>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Password"
                        label-cols-md="3"
                        label-for="user-password"
                    >
                        <b-form-input
                            id="user-password"
                            type="password"
                            v-model="newUser.password"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group
                        class="row"
                        label="Confirme Password"
                        label-cols-md="3"
                        label-for="user-confirmpassword"
                    >
                        <b-form-input
                            id="user-confirmpassword"
                            type="password"
                            v-model="confirmpass"
                        ></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="4" offset-md="6">
                    <b-row>
                        <b-col col sm="6" md="4" offset-md="0">
                            <b-button
                                variant="outline-primary"
                                @click="resetRegister"
                                >Limpiar</b-button
                            >
                        </b-col>
                        <b-col col sm="6" md="4" offset-md="1">
                            <b-button variant="warning" @click="createUser"
                                >Registrar</b-button
                            >
                        </b-col>
                    </b-row>
                </b-col>
            </b-row>
        </b-container>
    </panel>
</template>

<script>
export default {
    data() {
        return {
            busy: false,
            newUser: {},
            loading: null,
            confirmpass:'',
            roles:[]
        };
    },
    methods: {
        sendingEvent(file, xhr, formData) {
            Object.keys(this.newUser).forEach((key) => {
                formData.append(key, this.newUser[key]);
            });
        },
        sendSuccess() {
            this.registrationSuccessful();
            this.$swal.fire("Exito!", "Registro exitoso", "success");
        },
        createUser() {
            if(this.validarPassword())
            {
                console.log(this.newUser);
                this.$http({
                method:"POST",
                url:"/api/useradmin",
                data: this.newUser,
                })
                .then(()=>{
                    this.$swal.fire("Exito","Registro Exitoso","success");
                    this.sendSuccess();
                })
                .catch(()=>{
                    this.sendError();
                })
            }
            else {
                this.$swal.fire("Error!","Passwords no coinciden","error");
                return;
            }
            
        },
        cargarRoles(){
            this.$http({
                method:"GET",
                url:"/api/Roles"
            })
            .then((response)=>{
                this.roles=response.data.data;
            })
        },
        selectRol(Rol){
            this.newUser.role_id=Rol.id;
        },
        sendError() {
            this.$swal.fire("Error!", "Registro fallido", "error");
        },
        resetRegister() {
            this.$emit("resetRegister");
        },
        registrationSuccessful() {
            this.$emit("registrationSuccessful");
            this.resetRegister();
        },
        validarPassword(){
            if(this.newUser.password==this.confirmpass)
                return true;
            else 
                return false;
        }
    },
    mounted(){
        this.cargarRoles();
    }
};
</script>

<style scoped>

.subtitle {
    color: #314b5f;
    font-size: medium;
}
</style>
