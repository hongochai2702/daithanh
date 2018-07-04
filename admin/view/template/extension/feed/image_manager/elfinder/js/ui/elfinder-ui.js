

$.fn.elfinderoverlay = function(opts) {

	

	this.filter(':not(.elfinder-overlay)').each(function() {

		opts = $.extend({}, opts);

		$(this).addClass('ui-widget-overlay elfinder-overlay')

			.hide()

			.mousedown(function(e) {

				e.preventDefault();

				e.stopPropagation();

			})

			.data({

				cnt  : 0,

				show : typeof(opts.show) == 'function' ? opts.show : function() { },

				hide : typeof(opts.hide) == 'function' ? opts.hide : function() { }

			});

	});

	

	if (opts == 'show') {

		var o    = this.eq(0),

			cnt  = o.data('cnt') + 1,

			show = o.data('show');



		o.data('cnt', cnt);



		if (o.is(':hidden')) {

			o.zIndex(o.parent().zIndex()+1);

			o.show();

			show();

		}

	} 

	

	if (opts == 'hide') {

		var o    = this.eq(0),

			cnt  = o.data('cnt') - 1,

			hide = o.data('hide');

		

		o.data('cnt', cnt);

			

		if (cnt == 0 && o.is(':visible')) {

			o.hide();

			hide();        

		}

	}

	

	return this;

}



"use strict";

/**

 * @class elfinderworkzone - elFinder container for nav and current directory

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderworkzone = function(fm) {

	var cl = 'elfinder-workzone';

	

	this.not('.'+cl).each(function() {

		var wz     = $(this).addClass(cl),

			wdelta = wz.outerHeight(true) - wz.height(),

			parent = wz.parent();

			

		parent.add(window).bind('resize', function() {

				var height = parent.height();



				parent.children(':visible:not(.'+cl+')').each(function() {

					var ch = $(this);



					if (ch.css('position') != 'absolute' && ch.css('position') != 'fixed') {

						height -= ch.outerHeight(true);

					}

				});

				

				wz.height(height - wdelta);

			});

	});

	return this;

}





/**

 * @class elfindernav - elFinder container for diretories tree and places

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindernavbar = function(fm, opts) {



	this.not('.elfinder-navbar').each(function() {

		var nav    = $(this).addClass('ui-state-default elfinder-navbar'),

			parent = nav.parent()

				.resize(function() {

					nav.height(wz.height() - delta);

				}),

			wz     = parent.children('.elfinder-workzone').append(nav),

			delta  = nav.outerHeight() - nav.height(),

			ltr    = fm.direction == 'ltr',

			handle;



		

		if ($.fn.resizable) {

			handle = nav.resizable({

					handles : ltr ? 'e' : 'w',

					minWidth : opts.minWidth || 150,

					maxWidth : opts.maxWidth || 500

				})

				.bind('resize scroll', function() {

					var offset = (fm.UA.Opera && nav.scrollLeft())? 20 : 2;

					handle.css({

						top  : parseInt(nav.scrollTop())+'px',

						left : ltr ? 'auto' : parseInt(nav.scrollLeft() + offset),

						right: ltr ? parseInt(nav.scrollLeft() - offset) * -1 : 'auto'

					});

				})

				.find('.ui-resizable-handle').zIndex(nav.zIndex() + 10);



			if (!ltr) {

				nav.resize(function() {

					nav.css('left', null).css('right', 0);

				});

			}



			fm.one('open', function() {

				setTimeout(function() {

					nav.trigger('resize');

				}, 150);

			});

		}

	});

	

	return this;

};



"use strict";

/**

 * @class  elFinder dialog

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderdialog = function(opts) {

	var dialog;

	

	if (typeof(opts) == 'string' && (dialog = this.closest('.ui-dialog')).length) {

		if (opts == 'open') {

			dialog.css('display') == 'none' && dialog.fadeIn(120, function() {

				dialog.trigger('open');

			});

		} else if (opts == 'close') {

			dialog.css('display') != 'none' && dialog.hide().trigger('close');

		} else if (opts == 'destroy') {

			dialog.hide().remove();

		} else if (opts == 'toTop') {

			dialog.trigger('totop');

		}

	}

	

	opts = $.extend({}, $.fn.elfinderdialog.defaults, opts);



	this.filter(':not(.ui-dialog-content)').each(function() {

		var self       = $(this).addClass('ui-dialog-content ui-widget-content'),

			parent     = self.parent(),

			clactive   = 'elfinder-dialog-active',

			cldialog   = 'elfinder-dialog',

			clnotify   = 'elfinder-dialog-notify',

			clhover    = 'ui-state-hover',

			id         = parseInt(Math.random()*1000000),

			overlay    = parent.children('.elfinder-overlay'),

			buttonset  = $('<div class="ui-dialog-buttonset"/>'),

			buttonpane = $('<div class=" ui-helper-clearfix ui-dialog-buttonpane ui-widget-content"/>')

				.append(buttonset),

			

			dialog = $('<div class="ui-dialog ui-widget ui-widget-content ui-corner-all ui-draggable std42-dialog  '+cldialog+' '+opts.cssClass+'"/>')

				.hide()

				.append(self)

				.appendTo(parent)

				.draggable({ handle : '.ui-dialog-titlebar',

					     containment : 'document' })

				.css({

					width  : opts.width,

					height : opts.height

				})

				.mousedown(function(e) {

					e.stopPropagation();

					

					$(document).mousedown();



					if (!dialog.is('.'+clactive)) {

						parent.find('.'+cldialog+':visible').removeClass(clactive);

						dialog.addClass(clactive).zIndex(maxZIndex() + 1);

					}

				})

				.bind('open', function() {

					dialog.trigger('totop');

					typeof(opts.open) == 'function' && $.proxy(opts.open, self[0])();



					if (!dialog.is('.'+clnotify)) {

						

						parent.find('.'+cldialog+':visible').not('.'+clnotify).each(function() {

							var d     = $(this),

								top   = parseInt(d.css('top')),

								left  = parseInt(d.css('left')),

								_top  = parseInt(dialog.css('top')),

								_left = parseInt(dialog.css('left'))

								;



							if (d[0] != dialog[0] && (top == _top || left == _left)) {

								dialog.css({

									top  : (top+10)+'px',

									left : (left+10)+'px'

								});

							}

						});

					} 

				})

				.bind('close', function() {

					var dialogs = parent.find('.elfinder-dialog:visible'),

						z = maxZIndex();

					

					$(this).data('modal') && overlay.elfinderoverlay('hide');

					

					// get focus to next dialog

					if (dialogs.length) {

						dialogs.each(function() {

							var d = $(this);

							if (d.zIndex() >= z) {

								d.trigger('totop');

								return false;

							}

						})

					} else {

						// return focus to parent

						setTimeout(function() {

							parent.mousedown().click();

						}, 10);

						

					}

					

					if (typeof(opts.close) == 'function') {

						$.proxy(opts.close, self[0])();

					} else if (opts.destroyOnClose) {

						dialog.hide().remove();

					}

				})

				.bind('totop', function() {

					$(this).mousedown().find('.ui-button:first').focus().end().find(':text:first').focus();

					$(this).data('modal') && overlay.elfinderoverlay('show');

					overlay.zIndex($(this).zIndex());

				})

				.data({modal: opts.modal}),

				maxZIndex = function() {

					var z = parent.zIndex() + 10;

					parent.find('.'+cldialog+':visible').each(function() {

						var _z;

						if (this != dialog[0]) {

							_z = $(this).zIndex();

							if (_z > z) {

								z = _z;

							}

						}

					})

					return z;

				},

				top

			;

		

		if (!opts.position) {

			top = parseInt((parent.height() - dialog.outerHeight())/2 - 42);

			opts.position = {

				top  : (top > 0 ? top : 0)+'px',

				left : parseInt((parent.width() - dialog.outerWidth())/2)+'px'

			}

		} 

			

		dialog.css(opts.position);



		if (opts.closeOnEscape) {

			$(document).bind('keyup.'+id, function(e) {

				if (e.keyCode == $.ui.keyCode.ESCAPE && dialog.is('.'+clactive)) {

					self.elfinderdialog('close');

					$(document).unbind('keyup.'+id);

				}

			})

		}

		dialog.prepend(

			$('<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix">'+opts.title+'</div>')

				.prepend($('<a href="#" class="ui-dialog-titlebar-close ui-corner-all"><span class="ui-icon ui-icon-closethick"/></a>')

					.mousedown(function(e) {

						e.preventDefault();

						self.elfinderdialog('close');

					}))



		);

			

		

			

		$.each(opts.buttons, function(name, cb) {

			var button = $('<button type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"><span class="ui-button-text">'+name+'</span></button>')

				.click($.proxy(cb, self[0]))

				.hover(function(e) { $(this)[e.type == 'mouseenter' ? 'focus' : 'blur']() })

				.focus(function() { $(this).addClass(clhover) })

				.blur(function() { $(this).removeClass(clhover) })

				.keydown(function(e) { 

					var next;

					

					if (e.keyCode == $.ui.keyCode.ENTER) {

						$(this).click();

					}  else if (e.keyCode == $.ui.keyCode.TAB) {

						next = $(this).next('.ui-button');

						next.length ? next.focus() : $(this).parent().children('.ui-button:first').focus()

					}

				})

			buttonset.append(button);

		})

			

		buttonset.children().length && dialog.append(buttonpane);

		if (opts.resizable && $.fn.resizable) {

			dialog.resizable({

					minWidth   : opts.minWidth,

					minHeight  : opts.minHeight,

					alsoResize : this

				});

		} 

			

		typeof(opts.create) == 'function' && $.proxy(opts.create, this)();

			

		opts.autoOpen && self.elfinderdialog('open');



	});

	

	return this;

}



$.fn.elfinderdialog.defaults = {

	cssClass  : '',

	title     : '',

	modal     : false,

	resizable : true,

	autoOpen  : true,

	closeOnEscape : true,

	destroyOnClose : false,

	buttons   : {},

	position  : null,

	width     : 320,

	height    : 'auto',

	minWidth  : 200,

	minHeight : 110

}



"use strict";

/**

 * @class  elFinder folders tree

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindertree = function(fm, opts) {

	var treeclass = fm.res('class', 'tree');

	

	this.not('.'+treeclass).each(function() {



		var c = 'class',

			

			/**

			 * Root directory class name

			 *

			 * @type String

			 */

			root      = fm.res(c, 'treeroot'),



			/**

			 * Open root dir if not opened yet

			 *

			 * @type Boolean

			 */

			openRoot  = opts.openRootOnLoad,



			/**

			 * Subtree class name

			 *

			 * @type String

			 */

			subtree   = fm.res(c, 'navsubtree'),

			

			/**

			 * Directory class name

			 *

			 * @type String

			 */

			navdir    = fm.res(c, 'treedir'),

			

			/**

			 * Collapsed arrow class name

			 *

			 * @type String

			 */

			collapsed = fm.res(c, 'navcollapse'),

			

			/**

			 * Expanded arrow class name

			 *

			 * @type String

			 */

			expanded  = fm.res(c, 'navexpand'),

			

			/**

			 * Class name to mark arrow for directory with already loaded children

			 *

			 * @type String

			 */

			loaded    = 'elfinder-subtree-loaded',

			

			/**

			 * Arraw class name

			 *

			 * @type String

			 */

			arrow = fm.res(c, 'navarrow'),

			

			/**

			 * Current directory class name

			 *

			 * @type String

			 */

			active    = fm.res(c, 'active'),

			

			/**

			 * Droppable dirs dropover class

			 *

			 * @type String

			 */

			dropover = fm.res(c, 'adroppable'),

			

			/**

			 * Hover class name

			 *

			 * @type String

			 */

			hover    = fm.res(c, 'hover'),

			

			/**

			 * Disabled dir class name

			 *

			 * @type String

			 */

			disabled = fm.res(c, 'disabled'),

			

			/**

			 * Draggable dir class name

			 *

			 * @type String

			 */

			draggable = fm.res(c, 'draggable'),

			

			/**

			 * Droppable dir  class name

			 *

			 * @type String

			 */

			droppable = fm.res(c, 'droppable'),

			

			insideNavbar = function(x) {

				var left = navbar.offset().left;

					

				return left <= x && x <= left + navbar.width();

			},

			

			drop = fm.droppable.drop,

			

			/**

			 * Droppable options

			 *

			 * @type Object

			 */

			droppableopts = $.extend(true, {}, fm.droppable, {

				// show subfolders on dropover

				over : function(e) { 

					var link = $(this),

						cl   = hover+' '+dropover;



					if (insideNavbar(e.clientX)) {

						link.addClass(cl)

						if (link.is('.'+collapsed+':not(.'+expanded+')')) {

							setTimeout(function() {

								link.is('.'+dropover) && link.children('.'+arrow).click();

							}, 500);

						}

					} else {

						link.removeClass(cl);

					}

				},

				out : function() { $(this).removeClass(hover+' '+dropover); },

				drop : function(e, ui) { insideNavbar(e.clientX) && drop.call(this, e, ui); }

			}),

			

			spinner = $(fm.res('tpl', 'navspinner')),

			

			/**

			 * Directory html template

			 *

			 * @type String

			 */

			tpl = fm.res('tpl', 'navdir'),

			

			/**

			 * Permissions marker html template

			 *

			 * @type String

			 */

			ptpl = fm.res('tpl', 'perms'),

			

			/**

			 * Symlink marker html template

			 *

			 * @type String

			 */

			stpl = fm.res('tpl', 'symlink'),

			

			/**

			 * Html template replacement methods

			 *

			 * @type Object

			 */

			replace = {

				id          : function(dir) { return fm.navHash2Id(dir.hash) },

				cssclass    : function(dir) { return (dir.phash ? '' : root)+' '+navdir+' '+fm.perms2class(dir)+' '+(dir.dirs && !dir.link ? collapsed : ''); },

				permissions : function(dir) { return !dir.read || !dir.write ? ptpl : ''; },

				symlink     : function(dir) { return dir.alias ? stpl : ''; }

			},

			

			/**

			 * Return html for given dir

			 *

			 * @param  Object  directory

			 * @return String

			 */

			itemhtml = function(dir) {

				dir.name = fm.escape(dir.i18 || dir.name);

				

				return tpl.replace(/(?:\{([a-z]+)\})/ig, function(m, key) {

					return dir[key] || (replace[key] ? replace[key](dir) : '');

				});

			},

			

			/**

			 * Return only dirs from files list

			 *

			 * @param  Array  files list

			 * @return Array

			 */

			filter = function(files) {

				return $.map(files||[], function(f) { return f.mime == 'directory' ? f : null });

			},

			

			/**

			 * Find parent subtree for required directory

			 *

			 * @param  String  dir hash

			 * @return jQuery

			 */

			findSubtree = function(hash) {

				return hash ? tree.find('#'+fm.navHash2Id(hash)).next('.'+subtree) : tree;

			},

			

			/**

			 * Find directory (wrapper) in required node

			 * before which we can insert new directory

			 *

			 * @param  jQuery  parent directory

			 * @param  Object  new directory

			 * @return jQuery

			 */

			findSibling = function(subtree, dir) {

				var node = subtree.children(':first'),

					info;



				while (node.length) {

					info = fm.file(fm.navId2Hash(node.children('[id]').attr('id')));

					

					if ((info = fm.file(fm.navId2Hash(node.children('[id]').attr('id')))) 

					&& dir.name.toLowerCase().localeCompare(info.name.toLowerCase()) < 0) {

						return node;

					}

					node = node.next();

				}

				return $('');

			},

			

			/**

			 * Add new dirs in tree

			 *

			 * @param  Array  dirs list

			 * @return void

			 */

			updateTree = function(dirs) {

				var length  = dirs.length,

					orphans = [],

					i = dirs.length, 

					dir, html, parent, sibling;



				var firstVol = true; // check for netmount volume

				while (i--) {

					dir = dirs[i];



					if (tree.find('#'+fm.navHash2Id(dir.hash)).length) {

						continue;

					}

					

					if ((parent = findSubtree(dir.phash)).length) {

						html = itemhtml(dir);

						if (dir.phash && (sibling = findSibling(parent, dir)).length) {

							sibling.before(html);

						} else {

							parent[firstVol || dir.phash ? 'append' : 'prepend'](html);

							firstVol = false;

						}

					} else {

						orphans.push(dir);

					}

				}



				if (orphans.length && orphans.length < length) {

					return updateTree(orphans);

				} 

				

				setTimeout(function() {

					updateDroppable();

				}, 10);

				

			},

			

			/**

			 * Mark current directory as active

			 * If current directory is not in tree - load it and its parents

			 *

			 * @param {Boolean} do not recursive call

			 * @return void

			 */

			sync = function(stopRec) {

				var cwd     = fm.cwd().hash,

					current = tree.find('#'+fm.navHash2Id(cwd)), 

					rootNode, dir;

				

				if (openRoot) {

					rootNode = tree.find('#'+fm.navHash2Id(fm.root()));

					rootNode.is('.'+loaded) && rootNode.addClass(expanded).next('.'+subtree).show();

					openRoot = false;

				}

				

				if (!current.is('.'+active)) {

					tree.find('.'+navdir+'.'+active).removeClass(active);

					current.addClass(active);

				}



				if (opts.syncTree) {

					if (current.length) {

						return current.parentsUntil('.'+root).filter('.'+subtree).show().prev('.'+navdir).addClass(expanded);

					}

					if (fm.newAPI) {

						dir = fm.file(cwd);

						if (dir && dir.phash && tree.find('#'+fm.navHash2Id(dir.phash)).length) {

							updateTree([dir]);

							return sync();

						}

						fm.request({

							data : {cmd : 'parents', target : cwd},

							preventFail : true

						})

						.done(function(data) {

							var dirs = filter(data.tree);

							updateTree(dirs);

							updateArrows(dirs, loaded);

							cwd == fm.cwd().hash && sync(true);

						})

						;

					}

					

				}

			},

			

			/**

			 * Make writable and not root dirs droppable

			 *

			 * @return void

			 */

			updateDroppable = function() {

				tree.find('.'+navdir+':not(.'+droppable+',.elfinder-ro,.elfinder-na)').droppable(droppableopts);

			},

			

			/**

			 * Check required folders for subfolders and update arrow classes

			 *

			 * @param  Array  folders to check

			 * @param  String css class 

			 * @return void

			 */

			updateArrows = function(dirs, cls) {

				var sel = cls == loaded

						? '.'+collapsed+':not(.'+loaded+')'

						: ':not(.'+collapsed+')';



				

						

				//tree.find('.'+subtree+':has(*)').prev(':not(.'+collapsed+')').addClass(collapsed)



				$.each(dirs, function(i, dir) {

					tree.find('#'+fm.navHash2Id(dir.phash)+sel)

						.filter(function() { return $(this).next('.'+subtree).children().length > 0 })

						.addClass(cls);

				})

			},

			

			

			

			/**

			 * Navigation tree

			 *

			 * @type JQuery

			 */

			tree = $(this).addClass(treeclass)

				// make dirs draggable and toggle hover class

				.delegate('.'+navdir, 'hover', function(e) {

					var link  = $(this), 

						enter = e.type == 'mouseenter';

					

					if (!link.is('.'+dropover+' ,.'+disabled)) {

						enter && !link.is('.'+root+',.'+draggable+',.elfinder-na,.elfinder-wo') && link.draggable(fm.draggable);

						link.toggleClass(hover, enter);

					}

				})

				// add/remove dropover css class

				.delegate('.'+navdir, 'dropover dropout drop', function(e) {

					$(this)[e.type == 'dropover' ? 'addClass' : 'removeClass'](dropover+' '+hover);

				})

				// open dir or open subfolders in tree

				.delegate('.'+navdir, 'click', function(e) {

					var link = $(this),

						hash = fm.navId2Hash(link.attr('id')),

						file = fm.file(hash);

				

					fm.trigger('searchend');

				

					if (hash != fm.cwd().hash && !link.is('.'+disabled)) {

						fm.exec('open', file.thash || hash);

					} else if (link.is('.'+collapsed)) {

						link.children('.'+arrow).click();

					}

				})

				// toggle subfolders in tree

				.delegate('.'+navdir+'.'+collapsed+' .'+arrow, 'click', function(e) {

					var arrow = $(this),

						link  = arrow.parent('.'+navdir),

						stree = link.next('.'+subtree);



					e.stopPropagation();



					if (link.is('.'+loaded)) {

						link.toggleClass(expanded);

						stree.slideToggle()

					} else {

						spinner.insertBefore(arrow);

						link.removeClass(collapsed);



						fm.request({cmd : 'tree', target : fm.navId2Hash(link.attr('id'))})

							.done(function(data) { 

								updateTree(filter(data.tree)); 

								

								if (stree.children().length) {

									link.addClass(collapsed+' '+expanded);

									stree.slideDown();

								} 

								sync();

							})

							.always(function(data) {

								spinner.remove();

								link.addClass(loaded);

							});

					}

				})

				.delegate('.'+navdir, 'contextmenu', function(e) {

					e.preventDefault();



					fm.trigger('contextmenu', {

						'type'    : 'navbar',

						'targets' : [fm.navId2Hash($(this).attr('id'))],

						'x'       : e.clientX,

						'y'       : e.clientY

					});

				}),

			// move tree into navbar

			navbar = fm.getUI('navbar').append(tree).show()

				

			;



		fm.open(function(e) {

			var data = e.data,

				dirs = filter(data.files);



			data.init && tree.empty();



			if (dirs.length) {

				updateTree(dirs);

				updateArrows(dirs, loaded);

			} 

			sync();

		})

		// add new dirs

		.add(function(e) {

			var dirs = filter(e.data.added);



			if (dirs.length) {

				updateTree(dirs);

				updateArrows(dirs, collapsed);

			}

		})

		// update changed dirs

		.change(function(e) {

			var dirs = filter(e.data.changed),

				l    = dirs.length,

				dir, node, tmp, realParent, reqParent, realSibling, reqSibling, isExpanded, isLoaded;

			

			while (l--) {

				dir = dirs[l];

				if ((node = tree.find('#'+fm.navHash2Id(dir.hash))).length) {

					if (dir.phash) {

						realParent  = node.closest('.'+subtree);

						reqParent   = findSubtree(dir.phash);

						realSibling = node.parent().next();

						reqSibling  = findSibling(reqParent, dir);

						

						if (!reqParent.length) {

							continue;

						}

						

						if (reqParent[0] !== realParent[0] || realSibling.get(0) !== reqSibling.get(0)) {

							reqSibling.length ? reqSibling.before(node) : reqParent.append(node);

						}

					}

					isExpanded = node.is('.'+expanded);

					isLoaded   = node.is('.'+loaded);

					tmp        = $(itemhtml(dir));

					node.replaceWith(tmp.children('.'+navdir));

					

					if (dir.dirs 

					&& (isExpanded || isLoaded) 

					&& (node = tree.find('#'+fm.navHash2Id(dir.hash))) 

					&& node.next('.'+subtree).children().length) {

						isExpanded && node.addClass(expanded);

						isLoaded && node.addClass(loaded);

					}

				}

			}



			sync();

			updateDroppable();

		})

		// remove dirs

		.remove(function(e) {

			var dirs = e.data.removed,

				l    = dirs.length,

				node, stree;

			

			while (l--) {

				if ((node = tree.find('#'+fm.navHash2Id(dirs[l]))).length) {

					stree = node.closest('.'+subtree);

					node.parent().detach();

					if (!stree.children().length) {

						stree.hide().prev('.'+navdir).removeClass(collapsed+' '+expanded+' '+loaded);

					}

				}

			}

		})

		// add/remove active class for current dir

		.bind('search searchend', function(e) {

			tree.find('#'+fm.navHash2Id(fm.cwd().hash))[e.type == 'search' ? 'removeClass' : 'addClass'](active);

		})

		// lock/unlock dirs while moving

		.bind('lockfiles unlockfiles', function(e) {

			var lock = e.type == 'lockfiles',

				act  = lock ? 'disable' : 'enable',

				dirs = $.map(e.data.files||[], function(h) {  

					var dir = fm.file(h);

					return dir && dir.mime == 'directory' ? h : null;

				})

				

			$.each(dirs, function(i, hash) {

				var dir = tree.find('#'+fm.navHash2Id(hash));

				

				if (dir.length) {

					dir.is('.'+draggable) && dir.draggable(act);

					dir.is('.'+droppable) && dir.droppable(active);

					dir[lock ? 'addClass' : 'removeClass'](disabled);

				}

			});

		})



	});

	

	return this;

}



"use strict";

/**

 * elFinder current working directory ui.

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindercwd = function(fm, options) {

	

	this.not('.elfinder-cwd').each(function() {

		// fm.time('cwdLoad');

		

		var 

			list = fm.viewType == 'list',



			undef = 'undefined',

			/**

			 * Select event full name

			 *

			 * @type String

			 **/

			evtSelect = 'select.'+fm.namespace,

			

			/**

			 * Unselect event full name

			 *

			 * @type String

			 **/

			evtUnselect = 'unselect.'+fm.namespace,

			

			/**

			 * Disable event full name

			 *

			 * @type String

			 **/

			evtDisable = 'disable.'+fm.namespace,

			

			/**

			 * Disable event full name

			 *

			 * @type String

			 **/

			evtEnable = 'enable.'+fm.namespace,

			

			c = 'class',

			/**

			 * File css class

			 *

			 * @type String

			 **/

			clFile       = fm.res(c, 'cwdfile'),

			

			/**

			 * Selected css class

			 *

			 * @type String

			 **/

			fileSelector = '.'+clFile,

			

			/**

			 * Selected css class

			 *

			 * @type String

			 **/

			clSelected = 'ui-selected',

			

			/**

			 * Disabled css class

			 *

			 * @type String

			 **/

			clDisabled = fm.res(c, 'disabled'),

			

			/**

			 * Draggable css class

			 *

			 * @type String

			 **/

			clDraggable = fm.res(c, 'draggable'),

			

			/**

			 * Droppable css class

			 *

			 * @type String

			 **/

			clDroppable = fm.res(c, 'droppable'),

			

			/**

			 * Hover css class

			 *

			 * @type String

			 **/

			clHover     = fm.res(c, 'hover'), 



			/**

			 * Hover css class

			 *

			 * @type String

			 **/

			clDropActive = fm.res(c, 'adroppable'),



			/**

			 * Css class for temporary nodes (for mkdir/mkfile) commands

			 *

			 * @type String

			 **/

			clTmp = clFile+'-tmp',



			/**

			 * Number of thumbnails to load in one request (new api only)

			 *

			 * @type Number

			 **/

			tmbNum = fm.options.loadTmbs > 0 ? fm.options.loadTmbs : 5,

			

			/**

			 * Current search query.

			 *

			 * @type String

			 */

			query = '',

			

			lastSearch = [],



			/**

			 * File templates

			 *

			 * @type Object

			 **/

			templates = {

				icon : '<div id="{hash}" class="'+clFile+' {permsclass} {dirclass} ui-corner-all" title="{tooltip}"><div class="elfinder-cwd-file-wrapper ui-corner-all"><div class="elfinder-cwd-icon {mime} ui-corner-all" unselectable="on" {style}/>{marker}</div><div class="elfinder-cwd-filename" title="{name}">{name}</div></div>',

				row  : '<tr id="{hash}" class="'+clFile+' {permsclass} {dirclass}" title="{tooltip}"><td><div class="elfinder-cwd-file-wrapper"><span class="elfinder-cwd-icon {mime}"/>{marker}<span class="elfinder-cwd-filename">{name}</span></div></td><td>{perms}</td><td>{date}</td><td>{size}</td><td>{kind}</td></tr>'

			},

			

			permsTpl = fm.res('tpl', 'perms'),

			

			symlinkTpl = fm.res('tpl', 'symlink'),

			

			/**

			 * Template placeholders replacement rules

			 *

			 * @type Object

			 **/

			replacement = {

				permsclass : function(f) {

					return fm.perms2class(f);

				},

				perms : function(f) {

					return fm.formatPermissions(f);

				},

				dirclass : function(f) {

					return f.mime == 'directory' ? 'directory' : '';

				},

				mime : function(f) {

					return fm.mime2class(f.mime);

				},

				size : function(f) {

					return fm.formatSize(f.size);

				},

				date : function(f) {

					return fm.formatDate(f);

				},

				kind : function(f) {

					return fm.mime2kind(f);

				},

				marker : function(f) {

					return (f.alias || f.mime == 'symlink-broken' ? symlinkTpl : '')+(!f.read || !f.write ? permsTpl : '');

				},

				tooltip : function(f) {

					var title = fm.formatDate(f) + (f.size > 0 ? ' ('+fm.formatSize(f.size)+')' : '');

					return f.tooltip? fm.escape(f.tooltip).replace(/"/g, '&quot;').replace(/\r/g, '&#13;') + '&#13;' + title : title;

				}

			},

			

			/**

			 * Return file html

			 *

			 * @param  Object  file info

			 * @return String

			 **/

			itemhtml = function(f) {

				f.name = fm.escape(f.name);

				return templates[list ? 'row' : 'icon']

						.replace(/\{([a-z]+)\}/g, function(s, e) { 

							return replacement[e] ? replacement[e](f) : (f[e] ? f[e] : ''); 

						});

			},

			

			/**

			 * Flag. Required for msie to avoid unselect files on dragstart

			 *

			 * @type Boolean

			 **/

			selectLock = false,

			

			/**

			 * Move selection to prev/next file

			 *

			 * @param String  move direction

			 * @param Boolean append to current selection

			 * @return void

			 * @rise select			

			 */

			select = function(keyCode, append) {

				var code     = $.ui.keyCode,

					prev     = keyCode == code.LEFT || keyCode == code.UP,

					sel      = cwd.find('[id].'+clSelected),

					selector = prev ? 'first:' : 'last',

					s, n, sib, top, left;



				function sibling(n, direction) {

					return n[direction+'All']('[id]:not(.'+clDisabled+'):not(.elfinder-cwd-parent):first');

				}

				

				if (sel.length) {

					s = sel.filter(prev ? ':first' : ':last');

					sib = sibling(s, prev ? 'prev' : 'next');

					

					if (!sib.length) {

						// there is no sibling on required side - do not move selection

						n = s;

					} else if (list || keyCode == code.LEFT || keyCode == code.RIGHT) {

						// find real prevoius file

						n = sib;

					} else {

						// find up/down side file in icons view

						top = s.position().top;

						left = s.position().left;



						n = s;

						if (prev) {

							do {

								n = n.prev('[id]');

							} while (n.length && !(n.position().top < top && n.position().left <= left));



							if (n.is('.'+clDisabled)) {

								n = sibling(n, 'next');

							}

						} else {

							do {

								n = n.next('[id]');

							} while (n.length && !(n.position().top > top && n.position().left >= left));

							

							if (n.is('.'+clDisabled)) {

								n = sibling(n, 'prev');

							}

							// there is row before last one - select last file

							if (!n.length) {

								sib = cwd.find('[id]:not(.'+clDisabled+'):last');

								if (sib.position().top > top) {

									n = sib;

								}

							}

						}

					}

					// !append && unselectAll();

				} else {

					// there are no selected file - select first/last one

					n = cwd.find('[id]:not(.'+clDisabled+'):not(.elfinder-cwd-parent):'+(prev ? 'last' : 'first'));

				}

				

				if (n && n.length && !n.is('.elfinder-cwd-parent')) {

					if (append) {

						// append new files to selected

						n = s.add(s[prev ? 'prevUntil' : 'nextUntil']('#'+n.attr('id'))).add(n);

					} else {

						// unselect selected files

						sel.trigger(evtUnselect);

					}

					// select file(s)

					n.trigger(evtSelect);

					// set its visible

					scrollToView(n.filter(prev ? ':first' : ':last'));

					// update cache/view

					trigger();

				}

			},

			

			selectedFiles = [],

			

			selectFile = function(hash) {

				cwd.find('#'+hash).trigger(evtSelect);

			},

			

			selectAll = function() {

				var phash = fm.cwd().hash;



				cwd.find('[id]:not(.'+clSelected+'):not(.elfinder-cwd-parent)').trigger(evtSelect); 

				selectedFiles = $.map(fm.files(), function(f) { return f.phash == phash ? f.hash : null ;});

				trigger();

			},

			

			/**

			 * Unselect all files

			 *

			 * @return void

			 */

			unselectAll = function() {

				selectedFiles = [];

				cwd.find('[id].'+clSelected).trigger(evtUnselect); 

				trigger();

			},

			

			/**

			 * Return selected files hashes list

			 *

			 * @return Array

			 */

			selected = function() {

				return selectedFiles;

			},

			

			/**

			 * Fire elfinder "select" event and pass selected files to it

			 *

			 * @return void

			 */

			trigger = function() {

				fm.trigger('select', {selected : selectedFiles});

			},

			

			/**

			 * Scroll file to set it visible

			 *

			 * @param DOMElement  file/dir node

			 * @return void

			 */

			scrollToView = function(o) {

				var ftop    = o.position().top,

					fheight = o.outerHeight(true),

					wtop    = wrapper.scrollTop(),

					wheight = wrapper.innerHeight();



				if (ftop + fheight > wtop + wheight) {

					wrapper.scrollTop(parseInt(ftop + fheight - wheight));

				} else if (ftop < wtop) {

					wrapper.scrollTop(ftop);

				}

			},

			

			/**

			 * Files we get from server but not show yet

			 *

			 * @type Array

			 **/

			buffer = [],

			

			/**

			 * Return index of elements with required hash in buffer 

			 *

			 * @param String  file hash

			 * @return Number

			 */

			index = function(hash) {

				var l = buffer.length;

				

				while (l--) {

					if (buffer[l].hash == hash) {

						return l;

					}

				}

				return -1;

			},

			

			/**

			 * Scroll event name

			 *

			 * @type String

			 **/

			scrollEvent = 'scroll.'+fm.namespace,



			/**

			 * Cwd scroll event handler.

			 * Lazy load - append to cwd not shown files

			 *

			 * @return void

			 */

			render = function() {

				var html  = [],  

					dirs  = false, 

					ltmb  = [],

					atmb  = {},

					last  = cwd.find('[id]:last'),

					top   = !last.length,

					place = list ? cwd.children('table').children('tbody') : cwd,

					files;



				if (!buffer.length) {

					return wrapper.unbind(scrollEvent);

				}

				

				while ((!last.length || last.position().top <= wrapper.height() + wrapper.scrollTop() + fm.options.showThreshold)

					&& (files = buffer.splice(0, fm.options.showFiles)).length) {

					

					html = $.map(files, function(f) {

						if (f.hash && f.name) {

							if (f.mime == 'directory') {

								dirs = true;

							}

							if (f.tmb) {

								f.tmb === 1 ? ltmb.push(f.hash) : (atmb[f.hash] = f.tmb);

							} 

							return itemhtml(f);

						}

						return null;

					});



					place.append(html.join(''));

					last = cwd.find('[id]:last');

					// scroll top on dir load to avoid scroll after page reload

					top && cwd.scrollTop(0);

					

				}



				// load/attach thumbnails

				attachThumbnails(atmb);

				ltmb.length && loadThumbnails(ltmb);



				// make directory droppable

				dirs && makeDroppable();

				

				if (selectedFiles.length) {

					place.find('[id]:not(.'+clSelected+'):not(.elfinder-cwd-parent)').each(function() {

						var id = this.id;

						

						$.inArray(id, selectedFiles) !== -1 && $(this).trigger(evtSelect);

					});

				}

				

			},

			

			/**

			 * Droppable options for cwd.

			 * Do not add class on childs file over

			 *

			 * @type Object

			 */

			droppable = $.extend({}, fm.droppable, {

				over : function(e, ui) { 

					var hash = fm.cwd().hash;

					$.each(ui.helper.data('files'), function(i, h) {

						if (fm.file(h).phash == hash) {

							cwd.removeClass(clDropActive);

							return false;

						}

					});

				}

			}),

			

			/**

			 * Make directory droppable

			 *

			 * @return void

			 */

			makeDroppable = function() {

				setTimeout(function() {

					cwd.find('.directory:not(.'+clDroppable+',.elfinder-na,.elfinder-ro)').droppable(fm.droppable);

				}, 20);

			},

			

			/**

			 * Preload required thumbnails and on load add css to files.

			 * Return false if required file is not visible yet (in buffer) -

			 * required for old api to stop loading thumbnails.

			 *

			 * @param  Object  file hash -> thumbnail map

			 * @return Boolean

			 */

			attachThumbnails = function(images) {

				var url = fm.option('tmbUrl'),

					ret = true, 

					ndx;

				

				$.each(images, function(hash, tmb) {

					var node = cwd.find('#'+hash);



					if (node.length) {



						(function(node, tmb) {

							$('<img/>')

								.load(function() { node.find('.elfinder-cwd-icon').css('background', "url('"+tmb+"') center center no-repeat"); })

								.attr('src', tmb);

						})(node, url+tmb);

					} else {

						ret = false;

						if ((ndx = index(hash)) != -1) {

							buffer[ndx].tmb = tmb;

						}

					}

				});

				return ret;

			},

			

			/**

			 * Load thumbnails from backend.

			 *

			 * @param  Array|Boolean  files hashes list for new api | true for old api

			 * @return void

			 */

			loadThumbnails = function(files) {

				var tmbs = [];

				

				if (fm.oldAPI) {

					fm.request({

						data : {cmd : 'tmb', current : fm.cwd().hash},

						preventFail : true

						})

						.done(function(data) {

							if (attachThumbnails(data.images||[]) && data.tmb) {

								loadThumbnails();

							}

						});

					return;

				} 



				tmbs = tmbs = files.splice(0, tmbNum);

				if (tmbs.length) {

					fm.request({

						data : {cmd : 'tmb', targets : tmbs},

						preventFail : true

					})

					.done(function(data) {

						if (attachThumbnails(data.images||[])) {

							loadThumbnails(files);

						}

					});

				}

			},

			

			/**

			 * Add new files to cwd/buffer

			 *

			 * @param  Array  new files

			 * @return void

			 */

			add = function(files) {

				var place    = list ? cwd.find('tbody') : cwd,

					l        = files.length, 

					ltmb     = [],

					atmb     = {},

					dirs     = false,

					findNode = function(file) {

						var pointer = cwd.find('[id]:first'), file2;



						while (pointer.length) {

							file2 = fm.file(pointer.attr('id'));

							if (!pointer.is('.elfinder-cwd-parent') && file2 && fm.compare(file, file2) < 0) {

								return pointer;

							}

							pointer = pointer.next('[id]');

						}

					},

					findIndex = function(file) {

						var l = buffer.length, i;

						

						for (i =0; i < l; i++) {

							if (fm.compare(file, buffer[i]) < 0) {

								return i;

							}

						}

						return l || -1;

					},

					file, hash, node, ndx;



				

				while (l--) {

					file = files[l];

					hash = file.hash;

					

					if (cwd.find('#'+hash).length) {

						continue;

					}

					

					if ((node = findNode(file)) && node.length) {

						node.before(itemhtml(file)); 

					} else if ((ndx = findIndex(file)) >= 0) {

						buffer.splice(ndx, 0, file);

					} else {

						place.append(itemhtml(file));

					}

					

					if (cwd.find('#'+hash).length) {

						if (file.mime == 'directory') {

							dirs = true;

						} else if (file.tmb) {

							file.tmb === 1 ? ltmb.push(hash) : (atmb[hash] = file.tmb);

						}

					}

				}

				

				attachThumbnails(atmb);

				ltmb.length && loadThumbnails(ltmb);

				dirs && makeDroppable();

			},

			

			/**

			 * Remove files from cwd/buffer

			 *

			 * @param  Array  files hashes

			 * @return void

			 */

			remove = function(files) {

				var l = files.length, hash, n, ndx;

				

				while (l--) {

					hash = files[l];

					if ((n = cwd.find('#'+hash)).length) {

						try {

							n.detach();

						} catch(e) {

							fm.debug('error', e);

						}

					} else if ((ndx = index(hash)) != -1) {

						buffer.splice(ndx, 1);

					}

				}

			},

			

			msg = {

				name : fm.i18n('name'),

				perm : fm.i18n('perms'),

				mod  : fm.i18n('modify'),

				size : fm.i18n('size'),

				kind : fm.i18n('kind')

			},

			

			/**

			 * Update directory content

			 *

			 * @param  Array  files

			 * @return void

			 */

			content = function(files, any) {

				var phash = fm.cwd().hash; 

				// console.log(files)

				

				unselectAll();

				

				try {

					// to avoid problem with draggable

					cwd.children('table,'+fileSelector).remove();

				} catch (e) {

					cwd.html('');

				}



				cwd.removeClass('elfinder-cwd-view-icons elfinder-cwd-view-list')

					.addClass('elfinder-cwd-view-'+(list ? 'list' :'icons'));



				wrapper[list ? 'addClass' : 'removeClass']('elfinder-cwd-wrapper-list');



				list && cwd.html('<table><thead><tr class="ui-state-default"><td >'+msg.name+'</td><td>'+msg.perm+'</td><td>'+msg.mod+'</td><td>'+msg.size+'</td><td>'+msg.kind+'</td></tr></thead><tbody/></table>');

		

				buffer = $.map(files, function(f) { return any || f.phash == phash ? f : null; });

				

				buffer = fm.sortFiles(buffer);

		

				wrapper.bind(scrollEvent, render).trigger(scrollEvent);

		

				phash = fm.cwd().phash;

				

				if (options.oldSchool && phash && !query) {

					var parent = $.extend(true, {}, fm.file(phash), {name : '..', mime : 'directory'});

					parent = $(itemhtml(parent))

						.addClass('elfinder-cwd-parent')

						.bind('mousedown click mouseup touchstart touchmove touchend dblclick mouseenter', function(e) {

						//.bind('mousedown click mouseup dblclick mouseenter', function(e) {

							e.preventDefault();

							e.stopPropagation();

						})

						.dblclick(function() {

							fm.exec('open', this.id);

						});



					(list ? cwd.find('tbody') : cwd).prepend(parent);

				}

				

			},

			

			/**

			 * CWD node itself

			 *

			 * @type JQuery

			 **/

			cwd = $(this)

				.addClass('ui-helper-clearfix elfinder-cwd')

				.attr('unselectable', 'on')

				// fix ui.selectable bugs and add shift+click support 

				.delegate(fileSelector, 'click.'+fm.namespace, function(e) {

					var p    = this.id ? $(this) : $(this).parents('[id]:first'), 

						prev = p.prevAll('.'+clSelected+':first'),

						next = p.nextAll('.'+clSelected+':first'),

						pl   = prev.length,

						nl   = next.length,

						sib;



					e.stopImmediatePropagation();



					if (e.shiftKey && (pl || nl)) {

						sib = pl ? p.prevUntil('#'+prev.attr('id')) : p.nextUntil('#'+next.attr('id'));

						sib.add(p).trigger(evtSelect);

					} else if (e.ctrlKey || e.metaKey) {

						p.trigger(p.is('.'+clSelected) ? evtUnselect : evtSelect);

					} else {

						if ($(this).data('touching') && p.is('.'+clSelected)) {

							$(this).data('touching', null);

							fm.dblclick({file : this.id});

							unselectAll();

						} else {

							unselectAll();

							p.trigger(evtSelect);

						}

					}



					trigger();

				})

				// call fm.open()

				.delegate(fileSelector, 'dblclick.'+fm.namespace, function(e) {

					fm.dblclick({file : this.id});

				})

				// for touch device

				.delegate(fileSelector, 'touchstart.'+fm.namespace, function(e) {

					$(this).data('touching', true);

					var p = this.id ? $(this) : $(this).parents('[id]:first'),

					  sel = p.prevAll('.'+clSelected+':first').length +

					        p.nextAll('.'+clSelected+':first').length;

					$(this).data('longtap', setTimeout(function(){

						// long tap

						p.trigger(p.is('.'+clSelected) ? evtUnselect : evtSelect);

						trigger();

						if (sel == 0 && p.is('.'+clSelected)) {

							p.trigger('click');

							trigger();

						} 

					}, 500));

				})

				.delegate(fileSelector, 'touchmove.'+fm.namespace+' touchend.'+fm.namespace, function(e) {

					clearTimeout($(this).data('longtap'));

				})

				// attach draggable

				.delegate(fileSelector, 'mouseenter.'+fm.namespace, function(e) {

					var $this = $(this),

						target = list ? $this : $this.children();



					if (!$this.is('.'+clTmp) && !target.is('.'+clDraggable+',.'+clDisabled)) {

						target.draggable(fm.draggable);

					}

				})

				// add hover class to selected file

				.delegate(fileSelector, evtSelect, function(e) {

					var $this = $(this), 

						id    = $this.attr('id');

					

					if (!selectLock && !$this.is('.'+clDisabled)) {

						$this.addClass(clSelected).children().addClass(clHover);

						if ($.inArray(id, selectedFiles) === -1) {

							selectedFiles.push(id);

						}

					}

				})

				// remove hover class from unselected file

				.delegate(fileSelector, evtUnselect, function(e) {

					var $this = $(this), 

						id    = $this.attr('id'),

						ndx;

					

					if (!selectLock) {

						$(this).removeClass(clSelected).children().removeClass(clHover);

						ndx = $.inArray(id, selectedFiles);

						if (ndx !== -1) {

							selectedFiles.splice(ndx, 1);

						}

					}

					

				})

				// disable files wich removing or moving

				.delegate(fileSelector, evtDisable, function() {

					var $this  = $(this).removeClass(clSelected).addClass(clDisabled), 

						target = (list ? $this : $this.children()).removeClass(clHover);

					

					$this.is('.'+clDroppable) && $this.droppable('disable');

					target.is('.'+clDraggable) && target.draggable('disable');

					!list && target.removeClass(clDisabled);

				})

				// if any files was not removed/moved - unlock its

				.delegate(fileSelector, evtEnable, function() {

					var $this  = $(this).removeClass(clDisabled), 

						target = list ? $this : $this.children();

					

					$this.is('.'+clDroppable) && $this.droppable('enable');	

					target.is('.'+clDraggable) && target.draggable('enable');

				})

				.delegate(fileSelector, 'scrolltoview', function() {

					scrollToView($(this));

				})

				.delegate(fileSelector, 'mouseenter.'+fm.namespace+' mouseleave.'+fm.namespace, function(e) {

					fm.trigger('hover', {hash : $(this).attr('id'), type : e.type});

					$(this).toggleClass('ui-state-hover');

				})

				.bind('contextmenu.'+fm.namespace, function(e) {

					var file = $(e.target).closest('.'+clFile);

					

					if (file.length) {

						e.stopPropagation();

						e.preventDefault();

						if (!file.is('.'+clDisabled)) {

							if (!file.is('.'+clSelected)) {

								// cwd.trigger('unselectall');

								unselectAll();

								file.trigger(evtSelect);

								trigger();

							}

							fm.trigger('contextmenu', {

								'type'    : 'files',

								'targets' : fm.selected(),

								'x'       : e.clientX,

								'y'       : e.clientY

							});



						}

						

					}

					// e.preventDefault();

					

					

				})

				// unselect all on cwd click

				.bind('click.'+fm.namespace, function(e) {

					!e.shiftKey && !e.ctrlKey && !e.metaKey && unselectAll();

				})

				

				// make files selectable

				.selectable({

					filter     : fileSelector,

					stop       : trigger,

					delay      : 250,

					selected   : function(e, ui) { $(ui.selected).trigger(evtSelect); },

					unselected : function(e, ui) { $(ui.unselected).trigger(evtUnselect); }

				})

				// make cwd itself droppable for folders from nav panel

				.droppable(droppable)

				// prepend fake file/dir

				.bind('create.'+fm.namespace, function(e, file) {

					var parent = list ? cwd.find('tbody') : cwd,

						p = parent.find('.elfinder-cwd-parent'),

						file = $(itemhtml(file)).addClass(clTmp);

						

					unselectAll();



					if (p.length) {

						p.after(file);

					} else {

						parent.prepend(file);

					}

					

					cwd.scrollTop(0);

				})

				// unselect all selected files

				.bind('unselectall', unselectAll)

				.bind('selectfile', function(e, id) {

					cwd.find('#'+id).trigger(evtSelect);

					trigger();

				}),

			wrapper = $('<div class="elfinder-cwd-wrapper"/>')

				.bind('contextmenu', function(e) {

					e.preventDefault();

					fm.trigger('contextmenu', {

						'type'    : 'cwd',

						'targets' : [fm.cwd().hash],

						'x'       : e.clientX,

						'y'       : e.clientY

					});

					

				}),

			

			resize = function() {

				var h = 0;



				wrapper.siblings('.elfinder-panel:visible').each(function() {

					h += $(this).outerHeight(true);

				});



				wrapper.height(wz.height() - h);

			},

			

			// elfinder node

			parent = $(this).parent().resize(resize),

			// workzone node

			wz = parent.children('.elfinder-workzone').append(wrapper.append(this))

			;

			

		

		if (fm.dragUpload) {

			wrapper[0].addEventListener('dragenter', function(e) {

				e.preventDefault();

				e.stopPropagation();

				

				wrapper.addClass(clDropActive);

			}, false);



			wrapper[0].addEventListener('dragleave', function(e) {

				e.preventDefault();

				e.stopPropagation();

				e.target == cwd[0] && wrapper.removeClass(clDropActive);

			}, false);



			wrapper[0].addEventListener('dragover', function(e) {

				e.preventDefault();

				e.stopPropagation();

			}, false);



			wrapper[0].addEventListener('drop', function(e) {

			  	e.preventDefault();

				wrapper.removeClass(clDropActive);



				e.dataTransfer && e.dataTransfer.files &&  e.dataTransfer.files.length && fm.exec('upload', {files : e.dataTransfer.files})//fm.upload({files : e.dataTransfer.files});

			}, false);

		}



		fm

			.bind('open', function(e) {

				content(e.data.files);

			})

			.bind('search', function(e) {

				lastSearch = e.data.files;

				content(lastSearch, true);

			})

			.bind('searchend', function() {

				lastSearch = [];

				if (query) {

					query = '';

					content(fm.files());

				}

			})

			.bind('searchstart', function(e) {

				query = e.data.query;

			})

			.bind('sortchange', function() {

				content(query ? lastSearch : fm.files(), !!query);

			})

			.bind('viewchange', function() {

				var sel = fm.selected(),

					l   = fm.storage('view') == 'list';

				

				if (l != list) {

					list = l;

					content(query ? lastSearch : fm.files(), !!query);



					$.each(sel, function(i, h) {

						selectFile(h);

					});

					trigger();

				}

				resize();

			})

			.add(function(e) {

				var phash = fm.cwd().hash,

					files = query

						? $.map(e.data.added || [], function(f) { return f.name.indexOf(query) === -1 ? null : f ;})

						: $.map(e.data.added || [], function(f) { return f.phash == phash ? f : null; })

						;

				add(files);

			})

			.change(function(e) {

				var phash = fm.cwd().hash,

					sel   = fm.selected(),

					files;



				if (query) {

					$.each(e.data.changed || [], function(i, file) {

						remove([file.hash]);

						if (file.name.indexOf(query) !== -1) {

							add([file]);

							$.inArray(file.hash, sel) !== -1 && selectFile(file.hash);

						}

					});

				} else {

					$.each($.map(e.data.changed || [], function(f) { return f.phash == phash ? f : null; }), function(i, file) {

						remove([file.hash]);

						add([file]);

						$.inArray(file.hash, sel) !== -1 && selectFile(file.hash);

					});

				}

				

				trigger();

			})

			.remove(function(e) {

				remove(e.data.removed || []);

				trigger();

			})

			// fix cwd height if it less then wrapper

			.bind('open add search searchend', function() {

				cwd.css('height', 'auto');



				if (cwd.outerHeight(true) < wrapper.height()) {

					cwd.height(wrapper.height() - (cwd.outerHeight(true) - cwd.height()) - 2);

				} 

			})

			// select dragged file if no selected, disable selectable

			.dragstart(function(e) {

				var target = $(e.data.target),

					oe     = e.data.originalEvent;



				if (target.is(fileSelector)) {

					

					if (!target.is('.'+clSelected)) {

						!(oe.ctrlKey || oe.metaKey || oe.shiftKey) && unselectAll();

						target.trigger(evtSelect);

						trigger();

					}

					cwd.droppable('disable');

				}

				

				cwd.selectable('disable').removeClass(clDisabled);

				selectLock = true;

			})

			// enable selectable

			.dragstop(function() {

				cwd.selectable('enable').droppable('enable');

				selectLock = false;

			})

			.bind('lockfiles unlockfiles', function(e) {

				var event = e.type == 'lockfiles' ? evtDisable : evtEnable,

					files = e.data.files || [], 

					l     = files.length;

				

				while (l--) {

					cwd.find('#'+files[l]).trigger(event);

				}

				trigger();

			})

			// select new files after some actions

			.bind('mkdir mkfile duplicate upload rename archive extract', function(e) {

				var phash = fm.cwd().hash, files;

				

				unselectAll();



				$.each(e.data.added || [], function(i, file) { 

					file && file.phash == phash && selectFile(file.hash);

				});

				trigger();

			})

			.shortcut({

				pattern     :'ctrl+a', 

				description : 'selectall',

				callback    : selectAll

			})

			.shortcut({

				pattern     : 'left right up down shift+left shift+right shift+up shift+down',

				description : 'selectfiles',

				type        : 'keydown' , //fm.UA.Firefox || fm.UA.Opera ? 'keypress' : 'keydown',

				callback    : function(e) { select(e.keyCode, e.shiftKey); }

			})

			.shortcut({

				pattern     : 'home',

				description : 'selectffile',

				callback    : function(e) { 

					unselectAll();

					scrollToView(cwd.find('[id]:first').trigger(evtSelect));

					trigger();

				}

			})

			.shortcut({

				pattern     : 'end',

				description : 'selectlfile',

				callback    : function(e) { 

					unselectAll();

					scrollToView(cwd.find('[id]:last').trigger(evtSelect)) ;

					trigger();

				}

			});

		

	});

	

	// fm.timeEnd('cwdLoad')

	

	return this;

}

"use strict";

/**

 * @class  elFinder toolbar

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindertoolbar = function(fm, opts) {

	this.not('.elfinder-toolbar').each(function() {

		var commands = fm._commands,

			self     = $(this).addClass('ui-helper-clearfix ui-widget-header ui-corner-top elfinder-toolbar'),

			panels   = opts || [],

			l        = panels.length,

			i, cmd, panel, button;

		

		self.prev().length && self.parent().prepend(this);



		while (l--) {

			if (panels[l]) {

				panel = $('<div class="ui-widget-content ui-corner-all elfinder-buttonset"/>');

				i = panels[l].length;

				while (i--) {

					if ((cmd = commands[panels[l][i]])) {

						button = 'elfinder'+cmd.options.ui;

						$.fn[button] && panel.prepend($('<div/>')[button](cmd));

					}

				}

				

				panel.children().length && self.prepend(panel);

				panel.children(':gt(0)').before('<span class="ui-widget-content elfinder-toolbar-button-separator"/>');



			}

		}

		

		self.children().length && self.show();

	});

	

	return this;

}



"use strict"

/**

 * @class  elFinder toolbar button widget.

 * If command has variants - create menu

 *

 * @author Dmitry (dio) Levashov

 **/

var icon_bottom={

            back:    '<i class="fa fa-long-arrow-left"></i> ',

            forward:    '<i class="fa fa-long-arrow-right"></i> ',

            open:    '<i class="fa fa-folder-open"></i> ',

            download:    '<i class="fa fa-download"></i> ',

            info:    '<i class="fa fa-info-circle"></i> ',

            quicklook:    '<i class="fa fa-eye"></i> ',

            copy:    '<i class="fa fa-copy"></i> ',

            cut:    '<i class="fa  fa-cut"></i> ',

            paste:    '<i class="fa fa-paste"></i> ',

            rm:    '<i class="fa fa-eraser"></i> ',

            duplicate:    '<i class="fa fa-superscript"></i> ',

            rename:    '<i class="fa fa-file-text"></i> ',

            edit:    '<i class="fa fa-edit"></i> ',

            resize:    '<i class="fa fa-arrows-h"></i> ',

            extract:    '<i class="fa fa-dropbox"></i> ',

            archive:    '<i class="fa fa-cube"></i> ',

            extract:    '<i class="fa fa-dropbox"></i> ',

            view:    '<i class="fa fa-list-ul"></i> ',

            sort:    '<i class="fa fa-sort-alpha-asc"></i> ',

            help:    '<i class="fa fa-help"></i> ', 

            rename:    '<i class="fa fa-file-text"></i> ',

            mkdir:    '<i class="fa fa-folder"></i> ',

            mkfile:    '<i class="fa fa-file"></i> ',

            upload:    '<i class="fa fa-upload"></i> ',

            getfile:    '<i class="fa fa-puzzle-piece"></i> ',

            insertfiles:'<i class="fa fa-image"></i> ',

            mutiimage:'<i class="fa fa-image"></i> ',

            home:'<i class="fa fa-home"></i> ',

            up:'<i class="fa fa-long-arrow-up"></i> '

        };

$.fn.elfinderbutton = function(cmd) {

	return this.each(function() {

		 var text_bottom="";

			var has_text='no_text';

			if(icon_bottom[cmd.name]!=undefined){

				text_bottom=icon_bottom[cmd.name]+cmd.title;

				has_text='has_text';

       }

		var c        = 'class',

			fm       = cmd.fm,

			disabled = fm.res(c, 'disabled'),

			active   = fm.res(c, 'active'),

			hover    = fm.res(c, 'hover'),

			item     = 'elfinder-button-menu-item',

			selected = 'elfinder-button-menu-item-selected',

			menu,

			button   = $(this).addClass('ui-state-default elfinder-button '+has_text)

				.attr('title', cmd.title)

				.append('<span class="elfinder-button-icon  elfinder-button-icon-'+cmd.name+'"/>'+text_bottom+'</span>')

				.hover(function(e) { !button.is('.'+disabled) && button[e.type == 'mouseleave' ? 'removeClass' : 'addClass'](hover) /**button.toggleClass(hover);*/ })

				.click(function(e) { 

					if (!button.is('.'+disabled)) {

						if (menu && cmd.variants.length > 1) {

							// close other menus

							menu.is(':hidden') && cmd.fm.getUI().click();

							e.stopPropagation();

							menu.slideToggle(100);

						} else {

							cmd.exec();

						}

						

					}

				}),

			hideMenu = function() {

				menu.hide();

			};

			

		// if command has variants create menu

		if ($.isArray(cmd.variants)) {

			button.addClass('elfinder-menubutton');

			

			menu = $('<div class="ui-widget ui-widget-content elfinder-button-menu ui-corner-all"/>')

				.hide()

				.appendTo(button)

				.zIndex(12+button.zIndex())

				.delegate('.'+item, 'hover', function() { $(this).toggleClass(hover) })

				.delegate('.'+item, 'click', function(e) {

					e.preventDefault();

					e.stopPropagation();

					button.removeClass(hover);

					cmd.exec(cmd.fm.selected(), $(this).data('value'));

				});



			cmd.fm.bind('disable select', hideMenu).getUI().click(hideMenu);

			

			cmd.change(function() {

				menu.html('');

				$.each(cmd.variants, function(i, variant) {

					menu.append($('<div class="'+item+'">'+variant[1]+'</div>').data('value', variant[0]).addClass(variant[0] == cmd.value ? selected : ''));

				});

			});

		}	

			

		cmd.change(function() {

			if (cmd.disabled()) {

				button.removeClass(active+' '+hover).addClass(disabled);

			} else {

				button.removeClass(disabled);

				button[cmd.active() ? 'addClass' : 'removeClass'](active);

			}

		})

		.change();

	});

}

"use strict";

/**

 * @class  elFinder toolbar's button tor upload file

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderuploadbutton = function(cmd) {

	return this.each(function() {

		var button = $(this).elfinderbutton(cmd)

				.unbind('click'), 

			form = $('<form/>').appendTo(button),

			input = $('<input type="file" multiple="true"/>')

				.change(function() {

					var _input = $(this);

					if (_input.val()) {

						cmd.exec({input : _input.remove()[0]});

						input.clone(true).appendTo(form);

					} 

				});



		form.append(input.clone(true));

				

		cmd.change(function() {

			form[cmd.disabled() ? 'hide' : 'show']();

		})

		.change();

	});

}

"use strict"

/**

 * @class  elFinder toolbar button to switch current directory view.

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderviewbutton = function(cmd) {

	return this.each(function() {

		var button = $(this).elfinderbutton(cmd),

			icon   = button.children('.elfinder-button-icon');



		cmd.change(function() {

			var icons = cmd.value == 'icons';



			icon.toggleClass('elfinder-button-icon-view-list', icons);

			button.attr('title', cmd.fm.i18n(icons ? 'viewlist' : 'viewicons'));

		});

	});

}

"use strict";

/**

 * @class  elFinder toolbar search button widget.

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindersearchbutton = function(cmd) {

	return this.each(function() {

		var result = false,

			button = $(this).hide().addClass('ui-widget-content elfinder-button '+cmd.fm.res('class', 'searchbtn')+''),

			search = function() {

				var val = $.trim(input.val());

				if (val) {

					cmd.exec(val).done(function() {

						result = true;

						input.focus();

					});

					

				} else {

					cmd.fm.trigger('searchend');

				}

			},

			abort = function() {

				input.val('');

				if (result) {

					result = false;

					cmd.fm.trigger('searchend');

				}

			},

			input  = $('<input type="text" size="42"/>')

				.appendTo(button)

				// to avoid fm shortcuts on arrows

				.keypress(function(e) {

					e.stopPropagation();

				})

				.keydown(function(e) {

					e.stopPropagation();

					

					e.keyCode == 13 && search();

					

					if (e.keyCode== 27) {

						e.preventDefault();

						abort();

					}

				});

		

		$('<span class="ui-icon ui-icon-search" title="'+cmd.title+'"/>')

			.appendTo(button)

			.click(search);

		

		$('<span class="ui-icon ui-icon-close"/>')

			.appendTo(button)

			.click(abort);

		

		// wait when button will be added to DOM

		setTimeout(function() {

			button.parent().detach();

			cmd.fm.getUI('toolbar').prepend(button.show());

			// position icons for ie7

			if (cmd.fm.UA.ltIE7) {

				var icon = button.children(cmd.fm.direction == 'ltr' ? '.ui-icon-close' : '.ui-icon-search');

				icon.css({

					right : '',

					left  : parseInt(button.width())-icon.outerWidth(true)

				});

			}

		}, 200);

		

		cmd.fm

			.select(function() {

				input.blur();

			})

			.bind('searchend', function() {

				input.val('');

			})

			.shortcut({

				pattern     : 'ctrl+f f3',

				description : cmd.title,

				callback    : function() { input.select().focus(); }

			});



	});

};



"use strict"

/**

 * @class  elFinder toolbar button menu with sort variants.

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindersortbutton = function(cmd) {	

	return this.each(function() {

                var has_text='no_text', icon='';

                if(icon_bottom[cmd.name]!=undefined){

				has_text='has_text';

                                icon=icon_bottom[cmd.name];

                }

		var fm       = cmd.fm,

			name     = cmd.name,

			c        = 'class',

			disabled = fm.res(c, 'disabled'),

			hover    = fm.res(c, 'hover'),

			item     = 'elfinder-button-menu-item',

			selected = item+'-selected',

			asc      = selected+'-asc',

			desc     = selected+'-desc',

			button   = $(this).addClass('ui-state-default elfinder-button elfinder-menubutton elfiner-button-'+name+' '+has_text)

				.attr('title', cmd.title)

				.append('<span class="elfinder-button-icon elfinder-button-icon-view elfinder-button-icon-'+name+'"/>'+icon+' '+name)

				.hover(function(e) { !button.is('.'+disabled) && button.toggleClass(hover); })

				.click(function(e) {

					if (!button.is('.'+disabled)) {

						e.stopPropagation();

						menu.is(':hidden') && cmd.fm.getUI().click();

						menu.slideToggle(100);

					}

				}),

			menu = $('<div class="ui-widget ui-widget-content elfinder-button-menu ui-corner-all"/>')

				.hide()

				.appendTo(button)

				.zIndex(12+button.zIndex())

				.delegate('.'+item, 'hover', function() { $(this).toggleClass(hover) })

				.delegate('.'+item, 'click', function(e) {

					e.preventDefault();

					e.stopPropagation();

					hide();

				}),

			update = function() {

				menu.children(':not(:last)').removeClass(selected+' '+asc+' '+desc)

					.filter('[rel="'+fm.sortType+'"]')

					.addClass(selected+' '+(fm.sortOrder == 'asc' ? asc : desc));



				menu.children(':last').toggleClass(selected, fm.sortStickFolders);

			},

			hide = function() { menu.hide(); };

			

			

		$.each(fm.sortRules, function(name, value) {

			menu.append($('<div class="'+item+'" rel="'+name+'"><span class="ui-icon ui-icon-arrowthick-1-n"/><span class="ui-icon ui-icon-arrowthick-1-s"/>'+fm.i18n('sort'+name)+'</div>').data('type', name));

		});

		

		menu.children().click(function(e) {

			var type = $(this).attr('rel');

			

			cmd.exec([], {

				type  : type, 

				order : type == fm.sortType ? fm.sortOrder == 'asc' ? 'desc' : 'asc' : fm.sortOrder, 

				stick : fm.sortStickFolders

			});

		})

		

		$('<div class="'+item+' '+item+'-separated"><span class="ui-icon ui-icon-check"/>'+fm.i18n('sortFoldersFirst')+'</div>')

			.appendTo(menu)

			.click(function() {

				cmd.exec([], {type : fm.sortType, order : fm.sortOrder, stick : !fm.sortStickFolders});

			});		

		

		fm.bind('disable select', hide).getUI().click(hide);

			

		fm.bind('sortchange', update)

		

		if (menu.children().length > 1) {

			cmd.change(function() {

					button.toggleClass(disabled, cmd.disabled());

					update();

				})

				.change();

			

		} else {

			button.addClass(disabled);

		}



	});

	

}



$.fn.elfinderpanel = function(fm) {

	

	return this.each(function() {

		var panel = $(this).addClass('elfinder-panel ui-state-default ui-corner-all'),

			margin = 'margin-'+(fm.direction == 'ltr' ? 'left' : 'right');

		

		fm.one('load', function(e) {

			var navbar = fm.getUI('navbar');

			

			panel.css(margin, parseInt(navbar.outerWidth(true)));

			navbar.bind('resize', function() {

				panel.is(':visible') && panel.css(margin, parseInt(navbar.outerWidth(true)))

			})

		})

	})

}



"use strict";

/**

 * @class  elFinder contextmenu

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfindercontextmenu = function(fm) {

	

	return this.each(function() {

		var menu = $(this).addClass('ui-helper-reset ui-widget ui-state-default ui-corner-all elfinder-contextmenu elfinder-contextmenu-'+fm.direction)

				.hide()

				.appendTo('body')

				.delegate('.elfinder-contextmenu-item', 'mouseenter mouseleave', function() {

					$(this).toggleClass('ui-state-hover')

				}),

			subpos  = fm.direction == 'ltr' ? 'left' : 'right',

			types = $.extend({}, fm.options.contextmenu),

			tpl     = '<div class="elfinder-contextmenu-item"><span class="elfinder-button-icon {icon} elfinder-contextmenu-icon"/><span>{label}</span></div>',

			item = function(label, icon, callback) {

				return $(tpl.replace('{icon}', icon ? 'elfinder-button-icon-'+icon : '').replace('{label}', label))

					.click(function(e) {

						e.stopPropagation();

						e.stopPropagation();

						callback();

					})

			},

			

			open = function(x, y) {

				var win        = $(window),

					width      = menu.outerWidth(),

					height     = menu.outerHeight(),

					wwidth     = win.width(),

					wheight    = win.height(),

					scrolltop  = win.scrollTop(),

					scrollleft = win.scrollLeft(),

					css        = {

						top  : (y + height < wheight ? y : y - height > 0 ? y - height : y) + scrolltop,

						left : (x + width  < wwidth  ? x : x - width) + scrollleft,

						'z-index' : 100 + fm.getUI('workzone').zIndex()

					};



				menu.css(css)

					.show();

				

				css = {'z-index' : css['z-index']+10};

				css[subpos] = parseInt(menu.width());

				menu.find('.elfinder-contextmenu-sub').css(css);

			},

			

			close = function() {

				menu.hide().empty();

			},

			

			create = function(type, targets) {

				var sep = false;

				

				

				

				$.each(types[type]||[], function(i, name) {

					var cmd, node, submenu;

					

					if (name == '|' && sep) {

						menu.append('<div class="elfinder-contextmenu-separator"/>');

						sep = false;

						return;

					}

					

					cmd = fm.command(name);



					if (cmd && cmd.getstate(targets) != -1) {

						if (cmd.variants) {

							if (!cmd.variants.length) {

								return;

							}

							node = item(cmd.title, cmd.name, function() {});

							

							submenu = $('<div class="ui-corner-all elfinder-contextmenu-sub"/>')

								.appendTo(node.append('<span class="elfinder-contextmenu-arrow"/>'));

								

							node.addClass('elfinder-contextmenu-group')

								.hover(function() {

									submenu.toggle()

								})

								

							$.each(cmd.variants, function(i, variant) {

								submenu.append(

									$('<div class="elfinder-contextmenu-item"><span>'+variant[1]+'</span></div>')

										.click(function(e) {

											e.stopPropagation();

											close();

											cmd.exec(targets, variant[0]);

										})

								);

							});

								

						} else {

							node = item(cmd.title, cmd.name, function() {

								close();

								cmd.exec(targets);

							})

							

						}

						

						menu.append(node)

						sep = true;

					}

				})

			},

			

			createFromRaw = function(raw) {

				$.each(raw, function(i, data) {

					var node;

					

					if (data.label && typeof data.callback == 'function') {

						node = item(data.label, data.icon, function() {

							close();

							data.callback();

						});

						menu.append(node);

					}

				})

			};

		

		fm.one('load', function() {

			fm.bind('contextmenu', function(e) {

				var data = e.data;



				close();



				if (data.type && data.targets) {

					create(data.type, data.targets);

				} else if (data.raw) {

					createFromRaw(data.raw);

				}



				menu.children().length && open(data.x, data.y);

			})

			.one('destroy', function() { menu.remove(); })

			.bind('disable select', close)

			.getUI().click(close);

		});

		

	});

	

}

"use strict";

/**

 * @class elFinder ui

 * Display current folder path in statusbar.

 * Click on folder name in path - open folder

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderpath = function(fm) {

	return this.each(function() {

		var path = $(this).addClass('elfinder-path').html('&nbsp;')

				.delegate('a', 'click', function(e) {

					var hash = $(this).attr('href').substr(1);



					e.preventDefault();

					hash != fm.cwd().hash && fm.exec('open', hash);

				})

				.prependTo(fm.getUI('statusbar').show())



			fm.bind('open searchend', function() {

				var dirs = [];



				$.each(fm.parents(fm.cwd().hash), function(i, hash) {

					dirs.push('<a href="#'+hash+'">'+fm.escape(fm.file(hash).name)+'</a>');

				});



				path.html(dirs.join(fm.option('separator')));

			})

			.bind('search', function() {

				path.html(fm.i18n('searcresult'));

			});

	});

}



"use strict";

/**

 * @class elFinder ui

 * Display number of files/selected files and its size in statusbar

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderstat = function(fm) {

	return this.each(function() {

		var size       = $(this).addClass('elfinder-stat-size'),

			sel        = $('<div class="elfinder-stat-selected"/>'),

			titlesize  = fm.i18n('size').toLowerCase(),

			titleitems = fm.i18n('items').toLowerCase(),

			titlesel   = fm.i18n('selected'),

			setstat    = function(files, cwd) {

				var c = 0, 

					s = 0;



				$.each(files, function(i, file) {

					if (!cwd || file.phash == cwd) {

						c++;

						s += parseInt(file.size)||0;

					}

				})

				size.html(titleitems+': '+c+', '+titlesize+': '+fm.formatSize(s));

			};



		fm.getUI('statusbar').prepend(size).append(sel).show();

		

		fm

		.bind('open reload add remove change searchend', function() {

			setstat(fm.files(), fm.cwd().hash)

		})

		.search(function(e) {

			setstat(e.data.files);

		})

		.select(function() {

			var s = 0,

				c = 0,

				files = fm.selectedFiles();



			if (files.length == 1) {

				s = files[0].size;

				sel.html(fm.escape(files[0].name)+(s > 0 ? ', '+fm.formatSize(s) : ''));

				

				return;

			}



			$.each(files, function(i, file) {

				c++;

				s += parseInt(file.size)||0;

			});



			sel.html(c ? titlesel+': '+c+', '+titlesize+': '+fm.formatSize(s) : '&nbsp;');

		})



		;

	})

}



"use strict";

/**

 * @class elFinder places/favorites ui

 *

 * @author Dmitry (dio) Levashov

 **/

$.fn.elfinderplaces = function(fm, opts) {

	return this.each(function() {

		var dirs      = [],

			c         = 'class',

			navdir    = fm.res(c, 'navdir'),

			collapsed = fm.res(c, 'navcollapse'),

			expanded  = fm.res(c, 'navexpand'),

			hover     = fm.res(c, 'hover'),

			clroot    = fm.res(c, 'treeroot'),

			tpl       = fm.res('tpl', 'navdir'),

			ptpl      = fm.res('tpl', 'perms'),

			spinner   = $(fm.res('tpl', 'navspinner')),

			/**

			 * Convert places dir node into dir hash

			 *

			 * @param  String  directory id

			 * @return String

			 **/

			id2hash   = function(id) { return id.substr(6);	},

			/**

			 * Convert places dir node into dir hash

			 *

			 * @param  String  directory id

			 * @return String

			 **/

			hash2id   = function(hash) { return 'place-'+hash; },

			

			/**

			 * Save current places state

			 *

			 * @return void

			 **/

			save      = function() { fm.storage('places', dirs.join(',')); },

			/**

			 * Return node for given dir object

			 *

			 * @param  Object  directory object

			 * @return jQuery

			 **/

			create    = function(dir) {

				return $(tpl.replace(/\{id\}/, hash2id(dir.hash))

						.replace(/\{name\}/, fm.escape(dir.name))

						.replace(/\{cssclass\}/, fm.perms2class(dir))

						.replace(/\{permissions\}/, !dir.read || !dir.write ? ptpl : '')

						.replace(/\{symlink\}/, ''));

			},

			/**

			 * Add new node into places

			 *

			 * @param  Object  directory object

			 * @return void

			 **/

			add = function(dir) {

				var node = create(dir);



				if (subtree.children().length) {

					$.each(subtree.children(), function() {

						var current =  $(this);

						

						if (dir.name.localeCompare(current.children('.'+navdir).text()) < 0) {

							return !node.insertBefore(current);

						}

					});

				} 

				

				dirs.push(dir.hash);

				!node.parent().length && subtree.append(node);

				root.addClass(collapsed);

				node.draggable({

					appendTo : 'body',

					revert   : false,

					helper   : function() {

						var dir = $(this);

							

						dir.children().removeClass('ui-state-hover');

						

						return $('<div class="elfinder-place-drag elfinder-'+fm.direction+'"/>')

								.append(dir.clone())

								.data('hash', id2hash(dir.children(':first').attr('id')));



					},

					start    : function() { $(this).hide(); },

					stop     : function(e, ui) {

						var top    = places.offset().top,

							left   = places.offset().left,

							width  = places.width(),

							height = places.height(),

							x      = e.clientX,

							y      = e.clientY;

						

						if (x > left && x < left+width && y > top && y < y+height) {

							$(this).show();

						} else {

							remove(ui.helper.data('hash'));

							save();

						}

					}

				});

			}, 

			/**

			 * Remove dir from places

			 *

			 * @param  String  directory id

			 * @return void

			 **/

			remove = function(hash) {

				var ndx = $.inArray(hash, dirs);



				if (ndx !== -1) {

					dirs.splice(ndx, 1);

					subtree.find('#'+hash2id(hash)).parent().remove();

					!subtree.children().length && root.removeClass(collapsed+' '+expanded);

				}

			},

			/**

			 * Remove all dir from places

			 *

			 * @return void

			 **/

			clear = function() {

				subtree.empty();

				root.removeClass(collapsed+' '+expanded);

			},

			/**

			 * Node - wrapper for places root

			 *

			 * @type jQuery

			 **/

			wrapper = create({

					hash  : 'root-'+fm.namespace, 

					name  : fm.i18n(opts.name, 'places'),

					read  : true,

					write : true

				}),

			/**

			 * Places root node

			 *

			 * @type jQuery

			 **/

			root = wrapper.children('.'+navdir)

				.addClass(clroot)

				.click(function() {

					if (root.is('.'+collapsed)) {

						places.toggleClass(expanded);

						subtree.slideToggle();

						fm.storage('placesState', places.is('.'+expanded)? 1 : 0);

					}

				}),

			/**

			 * Container for dirs

			 *

			 * @type jQuery

			 **/

			subtree = wrapper.children('.'+fm.res(c, 'navsubtree')),

			/**

			 * Main places container

			 *

			 * @type jQuery

			 **/

			places = $(this).addClass(fm.res(c, 'tree')+' elfinder-places ui-corner-all')

				.hide()

				.append(wrapper)

				.appendTo(fm.getUI('navbar'))

				.delegate('.'+navdir, 'hover', function() {

					$(this).toggleClass('ui-state-hover');

				})

				.delegate('.'+navdir, 'click', function(e) {

					fm.exec('open', $(this).attr('id').substr(6));

				})

				.delegate('.'+navdir+':not(.'+clroot+')', 'contextmenu', function(e) {

					var hash = $(this).attr('id').substr(6);

					

					e.preventDefault();

					

					fm.trigger('contextmenu', {

						raw : [{

							label    : fm.i18n('rmFromPlaces'),

							icon     : 'rm',

							callback : function() { remove(hash); save(); }

						}],

						'x'       : e.clientX,

						'y'       : e.clientY

					})

					

				})

				.droppable({

					tolerance  : 'pointer',

					accept     : '.elfinder-cwd-file-wrapper,.elfinder-tree-dir,.elfinder-cwd-file',

					hoverClass : fm.res('class', 'adroppable'),

					drop       : function(e, ui) {

						var resolve = true;

						

						$.each(ui.helper.data('files'), function(i, hash) {

							var dir = fm.file(hash);

							

							if (dir && dir.mime == 'directory' && $.inArray(dir.hash, dirs) === -1) {

								add(dir);

							} else {

								resolve = false;

							}

						})

						save();

						resolve && ui.helper.hide();

					}

				});

	



		// on fm load - show places and load files from backend

		fm.one('load', function() {

			if (fm.oldAPI) {

				return;

			}

			

			places.show().parent().show();



			dirs = $.map(fm.storage('places').split(','), function(hash) { return hash || null});

			

			if (dirs.length) {

				root.prepend(spinner);

				

				fm.request({

					data : {cmd : 'info', targets : dirs},

					preventDefault : true

				})

				.done(function(data) {

					dirs = [];

					$.each(data.files, function(i, file) {

						file.mime == 'directory' && add(file);

					});

					save();

					if (fm.storage('placesState') > 0) {

						root.click();

					}

				})

				.always(function() {

					spinner.remove();

				})

			}

			



			fm.remove(function(e) {

				$.each(e.data.removed, function(i, hash) {

					remove(hash);

				});

				save();

			})

			.change(function(e) {

				$.each(e.data.changed, function(i, file) {

					if ($.inArray(file.hash, dirs) !== -1) {

						remove(file.hash);

						file.mime == 'directory' && add(file);

					}

				});

				save();

			})

			.bind('sync', function() {

				if (dirs.length) {

					root.prepend(spinner);



					fm.request({

						data : {cmd : 'info', targets : dirs},

						preventDefault : true

					})

					.done(function(data) {

						$.each(data.files || [], function(i, file) {

							if ($.inArray(file.hash, dirs) === -1) {

								remove(file.hash);

							}

						});

						save();

					})

					.always(function() {

						spinner.remove();

					});

				}

			})

			

		})

		

	});

}