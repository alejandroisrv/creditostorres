<template>
  <div>
    <section class="content-header">
      <h1>Ventas</h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-default">
            <div class="box-body text-right">
              <button class="btn btn-primary" @click="nuevaVenta">
                <i class="fa fa-plus mr-2"></i> Nuevo venta
              </button>
            </div>
          </div>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Listado de ventas <b v-if="tipo!=''">de {{ tipo }}</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table
                v-if=" ventas.length > 0 "
                id="example1"
                class="table table-bordered table-striped"
              >
                <thead>
                  <tr>
                    <th>Sucursal</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Municipio</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in ventas" :key="item.id">
                    <td>{{ }}</td>
                    <td>{{ }}</td>
                    <td>{{ }}</td>
                    <td>{{ }}</td>
                    <td>
                      <button class="btn btn-default btn-sm" @click="verVenta(item)">
                        <i class="fa fa-eye"></i>
                      </button>
                      <button class="btn btn-primary btn-sm" @click="editarVenta(item)">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button class="btn btn-danger btn-sm" @click="eliminarVenta(item.id)">
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div v-else>
                <p class="py-4">No se han encontrado ventass</p>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <modal-venta :productos="productos" :clientes="clientes"></modal-venta>
    </section>
  </div>
</template>

<script>
import modalVenta from "./modalVentas";
import { log } from "util";
export default {
  data() {
    return {
      urlModal: "",
      ventas: "",
      clientes: "",
      productos: "",
      tipo: ""
    };
  },
  components: {
    modalVenta
  },
  created() {
    this.getVentas();
    this.getProductos();
    this.getClientes();
    this.eventHub.$on("sendVentas", rs => {
      this.getVentas();
    });
    this.tipo = this.$route.params.tipo;
  },
  methods: {
    getVentas() {
      axios
        .get("/api/ventas")
        .then(rs => {
          this.ventas = rs.data;
          console.log(rs);
        })
        .catch(err => {
          console.log(err);
        });
    },
    getProductos() {
      axios
        .get("/api/productos")
        .then(rs => {
          this.productos = rs.data;
          console.log(rs);
        })
        .catch(err => {
          console.log(err);
        });
    },
    getClientes() {
      axios
        .get("/api/clientes")
        .then(rs => {
          this.clientes = rs.data;
          console.log(rs);
        })
        .catch(err => {
          console.log(err);
        });
    },
    nuevaVenta() {
      this.openModal();
    },
    notificacion(texto) {
      this.$noty.success(texto);
    },
    openModal() {
      this.eventHub.$emit("openModal");
    }
  }
};
</script>
