<script>
import BaseEditor from "./CodeEditorVue";
export default {
    extends: BaseEditor,
    props: {
        language: {
            type: String,
            default: 'text/x-markdown',
        }
    }
};
</script>
