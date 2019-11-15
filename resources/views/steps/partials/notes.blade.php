@if ($empty || !$zero_theory)
    <div class="tab-pane fade show active markdown" id="theory" role="tabpanel" aria-labelledby="v-theory-tab">
        @if ($step->is_notebook)
            <div style="width:100%; margin: -30px;" id="notebook">

            </div>
            <script>nbv.render(JSON.parse('{!! addslashes ( $step->theory) !!} '), document.getElementById('notebook'));</script>
        @else
            @parsedown($step->theory)
        @endif
        @if (!$step->lesson->is_open && ($course->teachers->contains($user) || $user->role=='admin') && $step->notes!='')

            <div>
                <h3>Комментарий для преподавателя</h3>
                @parsedown($step->notes)
            </div>

        @endif
    </div>
@endif