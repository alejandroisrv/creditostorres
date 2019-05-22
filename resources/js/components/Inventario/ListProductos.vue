<template>
  <div>

  </div>
</template>
<script>
import $ from "jquery";
export default {
  props:['productos'],
  methods: {
    editarProducto(producto) {
      this.productoModal = producto;
      this.tituloModal = "Editar producto";
      this.urlModal = "/api/producto/update/" + producto.id;
    },
    nuevoProducto() {
      this.productoModal = {
        nombre: "",
        descripcion: "",
        precioContado: "",
        precioCredito: "",
        precioCosto: "",
        comision: ""
      };
      this.tituloModal = "Nuevo producto";
      this.urlModal = "/api/producto/";
    },
    verProducto(producto) {},
    eliminarProducto(id) {
      axios
        .get(`/api/producto/delete/${id}`)
        .then(rs => {
          console.log(rs);
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>
