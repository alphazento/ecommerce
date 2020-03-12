<template>
    <codemirror v-model="innerValue" :options="cmOptions"  @changes="codeChanges"/>
</template>

<script>
import { codemirror } from 'vue-codemirror'
// import theme style
import 'codemirror/theme/base16-dark.css'

// base style
import 'codemirror/lib/codemirror.css'
// theme css
import 'codemirror/theme/mbo.css'
// language
import 'codemirror/mode/vue/vue.js'
// language
import 'codemirror/mode/markdown/markdown.js'
// active-line.js
import 'codemirror/addon/selection/active-line.js'
// styleSelectedText
import 'codemirror/addon/selection/mark-selection.js'
import 'codemirror/addon/search/searchcursor.js'
// highlightSelectionMatches
import 'codemirror/addon/scroll/annotatescrollbar.js'
import 'codemirror/addon/search/matchesonscrollbar.js'
import 'codemirror/addon/search/searchcursor.js'
import 'codemirror/addon/search/match-highlighter.js'
// keyMap
import 'codemirror/mode/clike/clike.js'
import 'codemirror/addon/edit/matchbrackets.js'
import 'codemirror/addon/comment/comment.js'
import 'codemirror/addon/dialog/dialog.js'
import 'codemirror/addon/dialog/dialog.css'
import 'codemirror/addon/search/searchcursor.js'
import 'codemirror/addon/search/search.js'
import 'codemirror/keymap/sublime.js'
// foldGutter
import 'codemirror/addon/fold/foldgutter.css'
import 'codemirror/addon/fold/brace-fold.js'
import 'codemirror/addon/fold/comment-fold.js'
import 'codemirror/addon/fold/foldcode.js'
import 'codemirror/addon/fold/foldgutter.js'
import 'codemirror/addon/fold/indent-fold.js'
import 'codemirror/addon/fold/markdown-fold.js'
import 'codemirror/addon/fold/xml-fold.js'

import BaseConfig from "./Base";
export default {
    components: { codemirror },
    extends: BaseConfig,
    props: {
        language: {
            type: String,
            default: 'text/x-vue',
        }
    },
    data () {
        return {
            cmOptions: {
                tabSize: 4,
                foldGutter: true,
                styleActiveLine: true,
                lineNumbers: true,
                line: true,
                mode: this.language,
                theme: 'mbo',
                keyMap: "sublime",
            },
            timer: null,
            dirty: false
        }
    },
    methods: {
        codeChanges() {
            this.dirty = true;
        },
        autoSave() {
            if (this.dirty) {
                this.valueChanged(this.innerValue);
                this.dirty = false;
            }
        },
        cancelAutoSave () { 
            clearInterval(this.timer);
        }
    },
    created() {
        console.log(this.cmOptions);
        this.timer = setInterval(this.autoSave, 30000);
    },
    beforeDestroy () {
        console.log('beforeDestroy')
        this.autoSave();
        this.cancelAutoSave();
    }
};
</script>
