import { TextAlign } from '@tiptap/extension-text-align'

export default function customizeTiptapEditor(editor) {
    editor.extensionManager.extensions.push(TextAlign.configure({
        types: ['heading', 'paragraph'],
    }))
}
