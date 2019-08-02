@if ($empty || !$zero_theory)
<div class="tab-pane fade show active  markdown" id="theory" role="tabpanel" aria-labelledby="v-theory-tab">

    @parsedown($step->theory)

    @if (!$step->lesson->is_open && ($course->teachers->contains($user) || $user->role=='admin') && $step->notes!='')

    <div>
        <h3>Комментарий для преподавателя</h3>
        @parsedown($step->notes)
    </div>

    @endif
</div>
@endif