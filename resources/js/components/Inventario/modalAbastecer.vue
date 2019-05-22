<template>
  <div>
    <div class="modal fade" id="modal-abastecer" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Abastecer productos</h4>
          </div>
          <div class="modal-body">
            <button @click="addCuadro" class="btn btn-primary fl-right">Añadir Producto</button>
            <div class="mt-4" id="cuadros"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cuadros: ""
    };
  },
  created() {
    this.addCuadro();
  },
  methods: {
    addCuadro() {
      let cuadro = "";
    }
  }
};
</script>
