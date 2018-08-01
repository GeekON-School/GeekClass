@extends('layouts.full')

@section('content')

    <div class="alchemy" id="alchemy"></div>

    <script src="{{url('js/vendor.js')}}"></script>
    <script src="{{url('js/alchemy.min.js')}}"></script>
    <script type="text/javascript">
        config = {
            directedEdges: true,
            fixRootNodes: true,
            dataSource: "{{url('/insider/core/network')}}",
            nodeCaption: 'title',
            cluster: true,
            alpha: 0,
            linkDistance: function(d) {
                return 10*(200/d.getProperties().level);
            },
            curvedEdges: true,
            forceLocked: false,
            nodeStyle: {
                "all": {
                    "radius": function(d) {
                        return 200/d.getProperties().level;
                    },

                }
            },
            clusterColours: ["#1B9E77","#D95F02","#7570B3","#E7298A","#66A61E","#E6AB02", "#12AB02", "#99AB02"]
        };
        alchemy = new Alchemy(config);
        d3.selectAll(".alchemy text")
            .style("display", "block")


    </script>
@endsection
