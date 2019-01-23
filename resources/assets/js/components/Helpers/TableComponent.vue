<template>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th v-for="field in fields" v-bind:class="[field.classes ? field.classes : '']">{{ field.display_name }}</th>
        </tr>
        <tr v-for="(item, index) in items">
            <!--<td>{{ item.id }}</td>-->
            <td>{{ item.name }}</td>
            <!--<td class="text-center" v-html="statuses[item.active]"></td>-->
            <td>
                <button type="button" class="btn btn-primary btn-xs" title="Edit" v-on:click="edit(item.id)">
                    <i class="fa fa-fw fa-pencil-square-o"></i>
                </button>
                <button type="button" class="btn btn-danger btn-xs" title="Delete" v-on:click="destroy(index)">
                    <i class="fa fa-fw fa-trash-o"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import DeleteButtonComponent from "./Buttons/DeleteButtonComponent";
export default {
  name: "TableComponent",
  components: {DeleteButtonComponent},
  props: ["fields", "items", "statuses", "currency"],
  methods: {
        destroy(index) {
            this.$parent.destroy(index);
        },
        edit(id) {
          this.$parent.edit(id);
        }
    },
    data() {
        return {};
    }
};
</script>

<style scoped>
</style>
