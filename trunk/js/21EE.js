function toggleFilter(triggerEl) { /* hace que se despliegue el menu preincipal *//////
	// get first unordered list element
	var ul = triggerEl.nextSibling;

	// if nodetype is a text node, get next sibling
	if (ul.nodeType == 3) {
		ul = ul.nextSibling;
	}
	
	if (ul) {
		if ( ul.style.display == '' || ul.style.display == 'block' ) {
			ul.parentNode.className = 'off';
			ul.style.display = 'none';
		}
		else {
			ul.parentNode.className = 'on';
			ul.style.display = 'block';
		}
	}
}

/*
togglePriceRangeFilter(triggerEl):
dentro del menu Rango de presios, sirve para esconder el menu
*/
function togglePriceRangeFilter(triggerEl) {
	var ul = triggerEl.parentNode.parentNode;

	// if nodetype is a text node, get next sibling
	if (ul.nodeType == 3) {
		ul = ul.nextSibling;
	}
	
	if (ul) {
		if ( ul.style.display == '' || ul.style.display == 'block' ) {
			ul.parentNode.className = 'off';
			ul.style.display = 'none';
		}
		else {
			ul.parentNode.className = 'on';
			ul.style.display = 'block';
		}
	}
}/**************** si  *****************/



function toggleChildren(triggerEl) {/**************** si  *****************/
	var li = triggerEl.parentNode;
	var children = li.getElementsByTagName('input');
	var parentChecked = children[0].checked ? true : false;

	// select/deselect all children
	for ( var i = 1; i < children.length; i++ ) 
		children[i].checked = parentChecked;
}/**************** si  *****************/

function toggleCheckbox(triggerEl) { /**************** si  *****************/
	var li = triggerEl.parentNode;
	var input = li.firstChild;

	// if nodetype is a text node, get next sibling
	if (input.nodeType == 3) {
		input = input.nextSibling;
	}
	
	if ( input.checked ) input.checked = false;
	else input.checked = true;
} /**************** si  *****************/



/*
exposeAllVendors(triggerEl): Se activa cuando se hace click en "Ver Mas" en el menu Distritos
*/
function exposeAllVendors(triggerEl) { /**************** si  *****************/
	var ul = triggerEl.parentNode;
	ul.style.overflow = 'auto';
	sortVendorNodes(ul);
}

function sortVendorNodes(ul) { /**************** si  *****************/
	// clone unordered list (shallow cloning)
	var ulClone = ul.cloneNode(false);
	var children = ul.childNodes;

	// sort bucket of elements
	var vendorIds = new Array();
	var vendorCount = 0;
	var selectedVendorIds = new Array();
	var selectedVendorCount = 0;
	for ( var i = 0; i < children.length; i++ ) {
		var id = children[i].getAttribute('id');
		if (id) {
			var checked = children[i].getElementsByTagName("input")[0].checked;
			if (checked) {
				 selectedVendorIds[selectedVendorCount] = id;
				 selectedVendorCount++;
			}
			else {
				 vendorIds[vendorCount] = id;
				 vendorCount++;
			}

		}
	}

	vendorIds.sort();

	for ( var i = 0; i < selectedVendorCount; i++ ) {
		var vendorId = selectedVendorIds[i];
		var li = document.getElementById(vendorId);
		li.style.display = 'block';
		ulClone.appendChild(li);
		ulClone.lastChild.getElementsByTagName("input")[0].setAttribute('checked', 'checked');
		ulClone.lastChild.getElementsByTagName("input")[0].setAttribute('defaultChecked', 'true');
	}
	for ( var i = 0; i < vendorCount; i++ ) {
		var vendorId = vendorIds[i];
		var li = document.getElementById(vendorId);
		li.style.display = 'block';
		ulClone.appendChild(li);
	}

	
	ulClone.style.width = '159px';
	ulClone.style.height = '190px';

	ul.parentNode.replaceChild(ulClone, ul);
	
}



/*
initFilters() : Hece que el menu aparesca sin desplegar
*/
function initFilters() {
	var ul = document.getElementById('sa_filters_main');
	var children = ul.getElementsByTagName('ul');
	var selectedNodes = new Array('count','total_count');
	selectedNodes['total_count'] = 0;
	var firstFilter = 0;
	for ( var i = 0; i < children.length; i++ ) {
		if ( children[i].className != 'sa_filters_sub' ) continue;
		if (! firstFilter ) {
			var li = children[i].parentNode;
			li.setAttribute('id', 'first');
			firstFilter = 1;
		}
		// are there children selected?
		selectedNodes['count'] = 0;
		var inputNodes = children[i].getElementsByTagName('input');
		for ( var j = 0; j < inputNodes.length; j++ ) {
			if ( inputNodes[j].type == 'checkbox' ) {
				inputNodes[j].disabled = false;
				var a = inputNodes[j].nextSibling.nextSibling;
				if (a) {
					a.setAttribute('href', 'javascript:void(0);');
				}
				if ( inputNodes[j].checked ) selectedNodes['count']++;
			}
		}

		selectedNodes['total_count'] += selectedNodes['count'];

		if (selectedNodes['count'] == 0) {
			children[i].style.display = 'none';
			children[i].parentNode.className = 'off';
		}
	}

	var vFilter = children[0]; // usually the first element
	var pRangeFilter = children[children.length-2]; // always last filter element (always exposed)

	// show / hide price range filter
	if ( pRangeFilter ) {
		var lo_p = document.filters.lo_p.value;
		var hi_p = document.filters.hi_p.value;
		if ( lo_p > 0 || hi_p > 0 ) {
			pRangeFilter.style.display = 'block';
			pRangeFilter.parentNode.className = 'on';
		}
	}

	var searchFilter = children[children.length-1]; // always last filter element (always exposed)

	if ( searchFilter ) {
		searchFilter.style.display = 'block';
		searchFilter.parentNode.className = 'on';
	}

	var easeOut = 1;
	var vendorNodes = vFilter.getElementsByTagName('input');
	for ( var j = 0; j < vendorNodes.length; j++ ) {
		if ( vendorNodes[j].type == 'checkbox' ) {
			if ( vendorNodes[j].checked ){
				document.getElementById('vendorFilters').parentNode.className = 'on';
				easeOut = 0;
				break;
			}

		}
	}

	// disable href on see more button
	if ( vFilter && vFilter.hasChildNodes() && selectedNodes['total_count'] <= 5 ) {
		// vendor filters have an id attribute for sorting
		if ( vFilter.firstChild.id ) {
			// Old version : display vendors if no other attrib filters have been selected
			// New version : display them anyway
			//if (easeOut) {
			 //show vendor filters after page loads + short delay (initial view only)
			//	window.addOnload( function() { setTimeout(displayVendorFilters, 500) } );
		//	}
			var a = vFilter.lastChild.lastChild;
			if ( a.href ) {
				if ( vFilter.childNodes.length > 6 ) 
					vFilter.lastChild.replaceChild(a.firstChild, a);
				else 
					vFilter.removeChild(vFilter.lastChild);
			}
		}
	}
}