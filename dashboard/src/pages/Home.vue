<template>
    <div>
        <!-- begin breadcrumb -->
        <ol class="breadcrumb float-xl-right">
            <li class="breadcrumb-item active">
                <a href="javascript:;">Home</a>
            </li>
        </ol>
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <h1 class="page-header">
            Dashboard
        </h1>
        <b-row>
            <b-button variant="success" @click="usuariosaplicacion">Usuarios Aplicación</b-button>
            <b-button variant="success" @click="usuariosfree">Usuarios Free vs Premium</b-button>
            <b-button variant="success" @click="usuariosPerfil">Usuarios por Perfil</b-button>
            <b-button variant="success" @click="usuariosCurso">Usuarios por Curso</b-button>
            <b-button variant="success" @click="pagosMembresia">Pagos por Membresia</b-button>
        </b-row>
        <!-- end page-header -->
       <div class="container">
           <b-row>
               <bar-chart v-if="loaded" :chartdata="chartdata" :options="options"/>
           </b-row>
       </div>
    </div>
</template>
<script>

import BarChart from './Chart.js'
export default {
    name:'BarChartContainer',
    components:{BarChart},
    data:()=>({
        loaded: false,
        chartdata: null,
        options:{
            responsive: true,
            maintainAspectRatio: false
        },
        data:[],
        colors:['rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)']
    }),
    methods:{
        usuariosaplicacion(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.loaded=false
            this.data=[]
            this.$http({
                method:'GET',
                url:'/api/Gusers'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    item.labels = item.labels.substring(0,10);
                    this.chartdata.labels.push(item.labels);
                    this.data.push(item.datasets);
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        },
        usuariosfree(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.data=[]
            this.loaded=false
            this.$http({
                method:'GET',
                url:'/api/Gfreepremium'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    this.chartdata.labels.push(item.labels==1?'Free':'Premium');
                    this.data.push(item.datasets);
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        },
        usuariosPerfil(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.data=[]
            this.loaded=false
            this.$http({
                method:'GET',
                url:'/api/Gprofileuser'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    this.chartdata.labels.push(item.labels);
                    this.data.push(item.datasets);
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        },
        usuariosCurso(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.data=[]
            this.loaded=false
            this.$http({
                method:'GET',
                url:'/api/Guserscourse'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    this.chartdata.labels.push(item.labels);
                    this.data.push(item.datasets)
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        },
        pagosMembresia(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.data=[]
            this.loaded=false
            this.$http({
                method:'GET',
                url:'/api/Pagosmembresia'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    this.chartdata.labels.push(item.labels);
                    this.data.push(item.datasets);
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        },
        pagosMensual(){
            this.chartdata= {
                    labels:[],
                    datasets:[{

                    }]
            }
            this.data=[]
            this.loaded=false
            this.$http({
                method:'GET',
                url:'/api/pagosmes'
            })
            .then((response)=>{
                response.data.data.forEach((item)=>{
                    this.chartdata.labels.push(item.labels);
                    this.data.push(item.datasets);
                })
                this.chartdata.datasets.push({'data':this.data,'backgroundColor':this.colors,'label':''});
                this.loaded=true;
            } );
        }


    },
    mounted () {
        this.usuariosaplicacion();
        
    }
}
</script>

