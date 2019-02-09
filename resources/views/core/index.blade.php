@extends('layouts.full')

@section('content')

    <div class="alchemy" id="alchemy"></div>

    <script src="{{url('js/vendor.js')}}"></script>
    <script src="{{url('js/alchemy.js')}}"></script>
    <script type="text/javascript">
        config = {
            directedEdges: true,
            fixRootNodes: true,
            dataSource: "{{url('/insider/core/network/'.$id.'?version='.$version)}}",
            nodeCaption: 'title',
            nodeClick: function (d) {
                edges = alchemy.getEdges(d.id);
                edges.forEach(function (edge) {

                    alchemy._edges[edge.id][0]._state='highlighted';
                    //alchemy._edges[edge.id][0]._style['opacity']='1';
                    alchemy._nodes[edge._properties.source]._state='highlighted';
                    //alchemy._nodes[edge._properties.source]._style['opacity']='1';
                    //console.log(alchemy._nodes[edge._properties.source]);

                    alchemy._edges[edge.id][0].setStyles()
                    alchemy._nodes[edge._properties.source].setStyles();
                })
            },

            cluster: true,
            alpha: 0,
            curvedEdges: true,
            forceLocked: false,
            nodeTypes: {"nodeType":["use", "exists"]},
            nodeStyle: {
                "all": {
                    "radius": function(d) {
                        return 200/d.getProperties().level;
                    }

                }
            },
            clusterColours: ["#1B9E77","#D95F02","#7570B3","#E7298A","#66A61E","#E6AB02", "#12AB02", "#99AB02"]
        };
        alchemy = new Alchemy(config);


    </script>
@endsection
