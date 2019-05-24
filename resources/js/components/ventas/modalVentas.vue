<template>
  <div>
    <bootstrap-modal
      ref="theModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">Nueva Venta</div>

      <div slot="body">
        <form @submit.prevent="send" id="ventaFrom">
          <div class="box-body">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label>Cliente</label>
                <select required name="cliente" class="form-control">
                  <option
                    v-for="cliente in clientes"
                    :value="cliente.id"
                    :key="cliente.id"
                  >{{ cliente.nombre }}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Tipo de venta</label>
                <select class="form-control" name="tipo_venta">
                  <option
                    v-for="tipoVenta in tiposVenta"
                    :key="tipoVenta.id"
                    :value="tipoVenta.id"
                  >{{ tipoVenta.nombre }}</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Numero de cuotas</label>
                <input type="text" name="cuotas" class="form-control">
              </div>
              <div class="form-group col-md-6">
                <label>Periodo de pago</label>
                <select class="form-control" name="periodo_pago">
                  <option value="Semanal">Semanal</option>
                  <option value="Quincenal">Quincenal</option>
                  <option value="Mensual">Mensual</option>
                </select>
              </div>

              <div class="form-group col-md-12">
                <label>Productos<i class="fa fa-plus mx-2" @click="addCuadro"></i>
                </label>
                <table class="table col-md-12 p-0" id="tabla-productos"></table>
              </div>
              <div class="form-group col-md-12">
                <label>Total</label>
                <input type="text" class="form-control" name="total" v-model="total">
              </div>
            </div>
            <button type="submit" style="visibility:hidden;"></button>
          </div>
        </form>
      </div>
      <div slot="footer">
        <button type="button" class="btn btn-default" @click="closeTheModal">Cancelar</button>
        <button type="submit" class="btn btn-primary" @click="send">Guardar</button>
      </div>
    </bootstrap-modal>
  </div>
</template>
<script>
import axios from "axios";
import $ from "jquery";
import { log } from "util";
export default {
  props: ["clientes", "productos"],
  data() {
    return {
      show: false,
      url: "/api/ventas",
      tiposVenta='',
      total:0
    };
  },
  components: {
    "bootstrap-modal": require("vue2-bootstrap-modal")
  },
  created() {
    this.getTiposVentas();
    this.eventHub.$on("openModal", rs => {
      this.openTheModal();
    });
  },
  methods: {
    send() {
      let venta = new FormData(document.getElementById("ventaFrom"));
      axios.post(this.url, venta).then(rs => {
        this.closeTheModal();
        this.eventHub.$emit("sendProducto");
        this.$noty.success("Nueva venta realizad con exito");
      });
    },
    addCuadro() {
      let cuadro = "<tr class='p'>";
      cuadro +=
        "<td class='col-md-6 py-2'> <select class='form-control' name='productos[]'><option>Selecciona producto</option>";
      this.productos.forEach(element => {
        cuadro += `<option value=${element.id}>`;
        cuadro += `${element.nombre}`;
        cuadro += "</option>";
      });
      cuadro += "</select></td>";
      cuadro +=
        "<td class='col-md-6 py-2'><input type='text' class='form-control' name='cantidad' placeholder='cantidad'></td></tr>";
      $("#tabla-productos").append(cuadro);
    },
    getTiposVentas(){
      axios.get('/api/ventas/tipos').then(response => {
        this.tiposVenta = response.data;
        console.log(response);

      })  
    },
    openTheModal() {
      this.$refs.theModal.open();
    },
    myOpenFunc() {
      console.log("hello");
    },
    closeTheModal() {
      this.$refs.theModal.close();
    }
  }
};
</script>

<style scoped>
.form-group {
  padding: 10px !important;
}
</style>

