<template>
  <div>
    <bootstrap-modal
      ref="abastecerModal"
      :need-header="true"
      :need-footer="true"
      :size="'large'"
      :opened="myOpenFunc"
    >
      <div slot="title">Abastecer inventario</div>

      <div slot="body">
        <form @submit.prevent="send">
          <div class="box-body">
            <button @click="addCuadro" class="btn btn-primary fl-right">Añadir Producto</button>
            <div class="mt-4" id="cuadros" v-for="(new_item,idx) in new_items" :key="idx+'item'">
              <div class="col-md-4">
                <multiselect
                  v-model="new_item.producto"
                  :options="productos"
                  :custom-label="nameWithLang"
                  placeholder="Seleciona un producto"
                  label="nombre"
                  track-by="nombre"
                ></multiselect>
              </div>
              <div class="col-md-4">
                <input
                  type="text"
                  v-model="new_item.cantidad"
                  id="cantidad"
                  placeholder="Cantidad"
                  class="form-control"
                >
              </div>
            </div>
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
import Multiselect from "vue-multiselect";
export default {
  props: ["productosList"],
  components: {
    Multiselect
  },
  data() {
    return {
      new_items: [
        {
          producto: 0,
          cantidad: 0
        }
      ],
      cuadros: ""
    };
  },
  computed: {
    productos() {
      productos = [];
      this.productosList.forEach(producto => {
        productos.push({
          id: producto.id,
          nombre: producto.nombre,
          cantidad: producto.cantidad,
          precio_contado: producto.precio_costo,
          precio_credito: producto.precio_credito
        });
      });

      return productos;
    }
  },
  created() {
    this.eventHub.$on("openAbastecer", () => {
      this.openAbastecer();
    });
  },
  methods: {
    addCuadro() {
      let cuadro = "";
    },
    nameWithLang({ nombre, cantidad }) {
      return `${nombre} disponible(s) ${cantidad}`;
    },
    myOpenFunc() {},
    openAbastecer() {
      this.$refs.abastecerModal.open();
    },
    closeAbastecer() {
      this.$refs.abastecerModal.close();
    }
  }
};
</script>
<style>
.form-control {
  height: 42px !important;
}
</style>

