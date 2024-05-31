// document.getElementById('searchInput').addEventListener('input', function() {
//     let query = this.value.trim();
    
//     if (query.length > 0) {
//         fetch(`/search?query=${query}`)
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.json(); 
//         })
//         .then(data => {
//             let searchResults = document.getElementById('searchResults');
//             let tab = document.getElementById('tableau');

//             tab.style.display = 'none';
//             searchResults.classList.remove('hidden');

//             if (searchResults) {
                
//                 searchResults.innerHTML = '';

//                 data.data.forEach(contact => {
//                     let row = document.createElement('tr');
//                     let status = '';
//                     if (contact.organisation) {
//                         if (contact.organisation.statut === "LEAD") {
//                             status = '<span class="bg-blue-500 text-white py-1 px-2 rounded-full text-xs">LEAD</span>';
//                         } else if (contact.organisation.statut === "CLIENT") {
//                             status = '<span class="bg-green-500 text-white py-1 px-2 rounded-full text-xs">CLIENT</span>';
//                         } else {
//                             status = '<span class="bg-yellow-300 text-white py-1 px-2 rounded-full text-xs">Autre</span>';
//                         }
//                     } else {
//                         status = 'N/A';
//                     }
//                     row.innerHTML = `
//                         <td class="py-4 px-6 border-b border-gray-200">${contact.nom}</td>
//                         <td class="py-4 px-6 border-b border-gray-200 truncate">${contact.organisation ? contact.organisation.nom : 'N/A'}</td>
//                         <td class="py-4 px-6 border-b border-gray-200">${status}</td>
//                         <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex space-x-5">
//                             <a href="#" class="text-indigo-600 hover:text-indigo-900">
//                                 <i class="fas fa-eye"></i>
//                             </a>
//                             <a href="#" class="text-indigo-600 hover:text-indigo-900">
//                                 <i class="fas fa-pencil-alt"></i>
//                             </a>                            
//                             <a href="#" class="text-red-600 hover:text-red-900">
//                                 <i class="fas fa-trash-alt"></i>
//                             </a>
//                         </td>
//                     `;
//                     searchResults.appendChild(row);
//                 });
//             } else {
//                 console.error('Element with ID "searchResults" not found.');
//             }
//         })
//         .catch(error => {
//             console.error('There was a problem with your fetch operation:', error);
//         });
//     } else {
//         let searchResults = document.querySelector('#searchResults');
//         let tab = document.getElementById('tableau');
//         tab.style.display = 'block'; 
//         if (searchResults) {
//             searchResults.classList.add('hidden'); 
//             searchResults.innerHTML = ''; 
//         } else {
//             console.error('Element with ID "searchResults" not found.');
//         }
//     }
// });
