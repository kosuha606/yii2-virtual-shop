window.Vue.component('AdminVersionField', {
    template: `
    <div>
        <label :for="'checkbox_'+id">
            {{ label }}
        </label>
        <p>
            Максимальное кол-во версий: {{ props.maxVersions }}
        </p>
        <hr>
        
        <div class="modal fade" id="modal-primary">
        <div class="modal-dialog" style="max-width: 1000px">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Просмотр версии</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-success">Восстановить</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
        
        <div v-for="version in props.versions">
            <div class="mb-2">
            Версия от {{ version.created_at }}
            </div>
            <div>
                <button data-toggle="modal" data-target="#modal-primary" class="btn btn-primary">Просмотр</button>
            </div>
            <hr>
        </div>
    </div>
`,
    name: "AdminVersionField",
    props: ['value', 'label', 'props'],
    data: function() {
        return {
            id: this._uid,
        };
    },
    mounted() {
        console.log(this.props.versions);
    },
    methods: {
        onChange(e) {
            var res = e.target.checked ? 1 : 0;

            this.$emit('input', res);
        }
    }
});