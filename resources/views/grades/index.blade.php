@extends('layout')

@section('title')
    Журнал
@endsection

@section('content')
    <!--Title-->
    <h4 class="text-primary text-center pb-3 pt-3">Журнал групи №{{ $group->number }}:</h4>

    <!--Add grades-->
    @can('teach')
        <a href="/grades/{{ $group->id }}/create" class="btn btn-success mb-3">Виставити бали</a>
    @endcan

    <!--Content-->
    <div class="row">
        <table class="table table-hover table-bordered">
            <caption class="text-center">Список груп</caption>
            <thead class="thead-light">
                <tr>
                    <th class="text-left align-middle" scope="col">Ім'я студента</th>
                    @foreach($subjects as $subject)
                        <th class="text-center align-middle" scope="col">{{ $subject->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($group->students as $student)
                <tr>
                    <td class="text-left align-middle">{{ $student->user->name }}</td>
                    @foreach($subjects as $subject)
                        <th class="text-center align-middle" scope="col">
                            @foreach($student->grades as $grade)
                                @if($grade->subject->id === $subject->id)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p>{{ $grade->grade }}</p>
                                        </div>
                                        @if(Auth::user()->can('update', $grade, Grade::class))
                                        <div class="col-md-4">
                                            <a href="/grades/{{ $group->id }}/{{ $grade->id }}/edit">
                                                <button type="button" class="btn btn-success">
                                                    <i class="fas fa-pen"></i>
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <form method="post" action="/grades/{{ $group->id }}/{{ $grade->id }}">
                                                @csrf
                                                {{ method_field('delete') }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>   
                                        </div>
                                        @endif
                                    </div>  
                                @endif
                            @endforeach
                        </th>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="/groups" class="btn btn-warning mb-3">Повернутися до списку груп</a>
@endsection