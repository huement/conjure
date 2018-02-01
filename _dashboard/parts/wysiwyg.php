<div id="wysiwyg_container" style="min-width:800px;min-height:600px;border:1px solid grey"></div>

<script src="monaco-editor/min/vs/loader.js"></script>
<script>
	require.config({ paths: { 'vs': 'monaco-editor/min/vs' }});
	require(['vs/editor/editor.main'], function() {
		var editor = monaco.editor.create(document.getElementById('wysiwyg_container'), {
			value: [
				'function x() {',
				'\tconsole.log("Witches Brew!");',
				'}'
			].join('\n'),
			language: 'javascript'
		});
	});
</script>
