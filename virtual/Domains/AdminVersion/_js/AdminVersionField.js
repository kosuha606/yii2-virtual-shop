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
              <h4 class="modal-title">
                Просмотр версии
                <small>{{vers.created_at}}</small>
              </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <detail
                    :key="'restore_detail_'+counter"
                    :restore-mode="true"
                    :hide-view-only="true"
                    tab-prefix="restore"
                    :id="_admin.model.id"
                    :detail-config="_admin.detail_config"
                    :save-url="'/admin/'+_admin.entity+'/detail'"
                    :item="_admin.model"
                    :additional-components="restoreAdmin.additional_config"
                    :detail-components="restoreAdmin.config">

                </detail>
            </div>
            <div class="modal-footer justify-content-between">
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
                <button 
                @click="onSelectVersion(version)"
                data-toggle="modal" data-target="#modal-primary" class="btn btn-primary">Просмотр</button>
            </div>
            <hr>
        </div>
    </div>
`,
    name: "AdminVersionField",
    props: ['value', 'label', 'props'],
    data: function() {
        return {
            counter: 1,
            id: this._uid,
            formConfig: {},
            formData: {},
            restoreAdmin: {},
            vers: {},
        };
    },
    created() {
        console.log(this.props.versions);
        this.restoreAdmin = JSON.parse(JSON.stringify(_admin));
        this.$forceUpdate();
    },
    methods: {
        onSelectVersion(vers) {
            this.vers = vers;
            this.formData = JSON.parse(vers.form_data);

            this.restoreAdmin.config.forEach((item) => {
                item.value = this.formData[item.field];
            });

            this.restoreAdmin.additional_config.forEach((addItem) => {
                if (!this.formData.secondary_form[addItem.relationClass]) {
                    return;
                }

                let data = this.formData.secondary_form[addItem.relationClass];

                addItem.dataConfig.forEach((dataConfigItem, index) => {
                    let realDataItem = data[index];
                    dataConfigItem.forEach((dataConfigItemField) => {
                        dataConfigItemField.value = realDataItem[dataConfigItemField.field];
                    });
                });
            });

            this.counter++;
            this.$forceUpdate();
        },
        onChange(e) {
            var res = e.target.checked ? 1 : 0;

            this.$emit('input', res);
        }
    }
});