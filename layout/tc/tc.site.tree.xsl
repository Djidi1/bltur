<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="container[@module = 'sitetree']">
        <input type="hidden" id="sitetree" value="{@tree}"/>
        <input type="hidden" id="edited_node_name" value="{@edited_node_name}"/>
        <div class="row">
            <div class="col-xs-6">
                <div id="default-tree"/>
            </div>
            <div class="col-xs-6">
                <div class="tur_setting">

                </div>
            </div>
        </div>
        <script>

            var $searchableTree = $('#default-tree').treeview({
                data: $('#sitetree').val(),
                enableLinks: false,
                onNodeSelected: function(event, node){
                    var url = '/tc/viewSiteTree-1/sub_act-edit/'+node.type+'-'+node.id;
                    $.get(url, function(data){
                        var tur_settings = $('.tur_setting').html(data);
                        $(tur_settings).find('select').select2({enableFiltering: true});
                    });
                    console.log(node);
                    console.log(node.id);
                }
            });

            var edited_node_name = $('#edited_node_name').val();
            find_and_open(edited_node_name);

            function find_and_open(pattern) {
                var options = {
                    ignoreCase: true,
                    exactMatch: false,
                    revealResults: true
                };
                selectableNodes = $searchableTree.treeview('search', [ pattern, options ]);
                $searchableTree.treeview('selectNode', [ selectableNodes, { silent: false }]);
            }
        </script>
    </xsl:template>
</xsl:stylesheet>