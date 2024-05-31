<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">
    <title>Dashboard</title>
</head>
<body class="bg-gray-200">
    <div class="rounded-lg overflow-hidden mx-4 md:mx-10 mt-5">
        <h1 class="text-3xl">Liste des contacts</h1>
        <div class="flex justify-between items-center">
            <form action="{{ route('contacts.search') }}" method="GET" class="max-w-96 mt-5">
                <div class="relative">
                    <input type="text" name="search" id="searchInput" class="w-96 border h-12 shadow p-4 rounded-lg dark:text-gray-800 dark:border-gray-700 dark:bg-gray-200" placeholder="Recherche...">
                </div>
            </form>
            <button onclick="showModal()" id="addContactBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                + Ajouter
            </button>            
        </div>
        <table class="w-full table-fixed mt-5">
            <thead>
                <tr class="bg-gray-100">
                    <th class="w-1/3 py-4 px-6 text-left text-gray-600 font-bold uppercase">Nom du contact</th>
                    <th class="w-1/3 py-4 px-6 text-left text-gray-600 font-bold uppercase">Société</th>
                    <th class="w-1/7 py-4 px-6 text-left text-gray-600 font-bold uppercase">Statut</th>
                    <th class="w-1/7 py-4 px-6 text-left text-gray-600 font-bold uppercase"></th>
                </tr>
            </thead>
            <tbody id="tableau" class="bg-white">
                @foreach ($contacts as $contact)
                <tr>
                    <td class="py-4 px-6 border-b border-gray-200">{{$contact->nom}}</td>
                    <td class="py-4 px-6 border-b border-gray-200 truncate">{{$contact->organisation->nom}}</td>
                    <td class="py-4 px-6 border-b border-gray-200 ">
                        @if ($contact->organisation->statut == "LEAD")
                            <span class="bg-blue-500 text-white py-1 px-2 rounded-full text-xs">{{$contact->organisation->statut}}</span>
                        @elseif ($contact->organisation->statut == "CLIENT")
                            <span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">{{$contact->organisation->statut}}</span>
                        @else
                        <span class="bg-yellow-300 text-white py-1 px-2 rounded-full text-xs">{{$contact->organisation->statut}}</span>
                        @endif
                    </td>
                    
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-5">
                        <a href="#" class="text-indigo-600 hover:text-indigo-900" onclick="showModalShow({{ $contact->id }})">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="#" class="text-indigo-600 hover:text-indigo-900" onclick="showModalUpdate({{ $contact->id }})">
                            <i class="fas fa-pencil-alt"></i>
                        </a>                            
                        <a href="#" class="text-red-600 hover:text-red-900" onclick="showModal_delete()">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>

            <tbody id="searchResults" class="bg-white hidden" >
                <!-- Les résultats de la recherche seront affichés ici -->
            </tbody>
        </table>
        
        <div class="mt-10">
            {{ $contacts->links() }}
        </div>
    </div>

    @include('modals.contacts.contact_add')
    @include('modals.contacts.contact_delete')
    @include('modals.contacts.contact_update')
    @include('modals.contacts.contact_show')
    
    {{-- <script src="{{ asset('js/search.js')}}"></script> --}}
    <script src="{{ asset('js/modals/contact_add.js')}}"></script>
    <script src="{{ asset('js/modals/contact_delete.js')}}"></script>
    <script src="{{ asset('js/modals/contact_update.js')}}"></script>
    <script src="{{ asset('js/modals/contact_show.js')}}"></script>
</body>
</html>
