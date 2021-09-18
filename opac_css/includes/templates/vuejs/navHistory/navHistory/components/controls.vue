<template>
    <div id="controls" class="groups_bouton" v-if="svg.accesControls">
    	<div class="left">
	        <button id="advance_mode" :class="[svg.advanceMode ? 'active' : '', 'bouton']" @click="advanceMode">{{ pmbmessages.getMessage('nav_history', 'nav_history_advance_mode') }}</button>
	    	<template v-if="svg.advanceMode">
		        <button id="move_mode" :class="[svg.moveMode ? 'move-mode-up' : 'move-mode-down', 'bouton']" @click="moveMode">{{ pmbmessages.getMessage('nav_history', 'nav_history_move') }}</button>
			    <button class="bouton" id="zoom_plus" @click="zoomPlus" :disabled="disabledZoomPlus">{{ pmbmessages.getMessage('nav_history', 'nav_history_zoom_more') }}</button>
			    <button class="bouton" id="zoom_moin" @click="zoomMoins" :disabled="disabledZoomMoins">{{ pmbmessages.getMessage('nav_history', 'nav_history_zoom_minus') }}</button>
			    <button class="bouton" id="recenter" @click="recenter">{{ pmbmessages.getMessage('nav_history', 'nav_history_refocus') }}</button>
			    <div class="bookmarks-controls">
				    <button id="bookmarks" :class="[!hiddenBookmarks ? 'active' : '', 'bouton']" @click="showBookmarks" :disabled="disabledBookmarks()">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
				    		<path class="favoris active" d="M 0 5.87 L 6.13 5.87 L 8 0 L 9.87 5.87 L 16 5.87 L 11.12 9.8 L 13.05 16 L 8 12.16 L 2.95 16 L 4.88 9.8 Z"/>
				    	</svg>
				    	{{ pmbmessages.getMessage('nav_history', 'nav_history_bookmarks') }}
				    </button>
			    	<div class="bookmarks" v-if="!hiddenBookmarks">
			    		<ul class="bookmarks_list">
			    			<li class="bookmark" v-for="bookmark in svg.bookmarksList" @click.stop="moveTo(bookmark)">
			    				{{ bookmark.title }} 
			    				<span class="remove-bookmark" @click.stop="removeBookmark(bookmark)">
			    					{{ pmbmessages.getMessage('nav_history', 'nav_history_bookmark_remove') }}
		    					</span>
		    				</li>
			    		</ul>
			    	</div>
			    </div>
	    	</template>
    	</div>
    	<div class="right" v-if="svg.advanceMode">
		    <button class="bouton" @click="goToLeft" :disabled="!hasPreviousRoute">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
				  <path d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5z"/>
				</svg>
			</button>
		    <button class="bouton" @click="goToRight" :disabled="!hasNextRoute">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
				  <path d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
				</svg>
			</button>
    	</div>
    </div>
</template>

<script>
	export default {
		name: "controls",
		props : [
		    "svg",
		    "routes",
		    "pmbmessages",
		    "navhistory"
	    ],
	    data: function () {
	        return {
	            scale: 1.5,
	            zoomMin: 0.00009,
	            zoomMax: 437.90,
	            hiddenBookmarks: true
	        }
	    },
	    computed: {
		    firstItem: function () {
	            let firstItem = {};
	            
	            if (this.routes && this.routes.length > 0) {
	                firstItem = this.routes[0];
	                for (let i = this.routes.length-1; i > -1; i--) {
	                    if (this.routes[i].timestamp < firstItem.timestamp) {
	                        firstItem = this.routes[i];
	                    }
	                }
	            }
	            
	            return firstItem;
	        },
	        disabledZoomMoins: function () {
	            return (this.svg.scale == this.zoomMin) ? true : false;
	        },
	        disabledZoomPlus: function () {
	            return (this.svg.scale == this.zoomMax) ? true : false;
	        },
	        hasNextRoute: function () {
	            return (this.nextRoute && this.nextRoute.id) ? true : false;
	        },
	        hasPreviousRoute: function () {
	            return (this.previousRoute && this.previousRoute.id) ? true : false;
	        },
	        nextRoute: function () {
	            let nextRoute = {};
		        for (let i = this.routes.length-1; i > -1; i--) {
					let route = this.routes[i];
					if (route.x > this.svg.viewBox.x && (route.x - this.svg.viewBox.x) >= 1000) {
					    nextRoute = route;
						break;
					}
				}
		        return nextRoute;
	        },
	        previousRoute: function () {
	            let previousRoute = {};
			    for (let i = 0; i < this.routes.length; i++) {
					let route = this.routes[i];
					if (route.x < this.svg.viewBox.x && (this.svg.viewBox.x - route.x) >= 100) {
					    previousRoute = route;
						break;
					}
				}
		        return previousRoute;
	        }
	    },
		methods: {
			hiddenTooltip: function () {
				// On masque le tooltip de l'item
	            this.svg.itemHover.itemId = 0;
			},
	        disabledBookmarks: function () {
	            if (Object.values(this.svg.bookmarksList).length <= 0) {
	                this.hiddenBookmarks = true;
		            return true;
	            }
	            return false;
	        },
		    goToRight: function () {
		        if (this.hasNextRoute === true) {
					this.moveToItem(this.nextRoute);
			    }
			},
			goToLeft: function () {
			    if (this.hasPreviousRoute === true) {
					this.moveToItem(this.previousRoute);
			    }
			},
			moveToItem: function (item) {
			 	
				this.svg.moving = false;
			 	this.svg.load = true;
			 	
				let height = this.svg.viewBox.height;
				let middle = height/2
			    let y = (item.y - middle);
				
				let x = item.x - (this.svg.viewBox.width/2);

				this.svg.viewBox.x = x;
				this.svg.viewBox.y = y;

			 	this.svg.load = false;
			},
			moveMode: function () {
			    this.hiddenTooltip();
			    this.svg.moveMode = !this.svg.moveMode;
			},
			recenter: function () {
			    this.hiddenTooltip();
				// Reset des positions / zoom
				this.svg.viewBox.x = 0;
				this.svg.viewBox.y = 0;
			    this.svg.scale = 1;
			    
			    // On active le focus
				this.svg.focus.active = true;
			},
			zoomPlus: function () {
			    this.hiddenTooltip();
			    let zoom = this.svg.scale*this.scale;
			    if (zoom > this.zoomMax) {
			        zoom = this.zoomMax;
			    }
			    this.svg.scale = zoom;
			},
			zoomMoins: function () {
			    this.hiddenTooltip();
			    let zoom = this.svg.scale/this.scale;
			    if (zoom < this.zoomMin) {
			        zoom = this.zoomMin;
			    }
			    this.svg.scale = zoom;
			},
			advanceMode: function () {
			    
			    this.svg.advanceMode = !this.svg.advanceMode;
			    if (!this.navhistory.init) {
				    this.$parent.getAllRoute();
			    } else {
			        this.recenter();
			    }
		        
		     	// On désactive le déplacement
			    if (this.svg.moveMode) {
			        this.moveMode();
			    }
			},
			showBookmarks: function () {
			    this.hiddenBookmarks = !this.hiddenBookmarks;
			},
	        removeBookmark: function(bookmark) {
	            this.$parent.removeBookmark(bookmark);
	        },
	        moveTo: function(bookmark) {
	            let x = this.computedXFromTime(bookmark.time);
	            this.svg.viewBox.x = x;
	        },
	        computedXFromTime: function (time) {
	            if (this.firstItem) {
	    	     	// Calcule du point x (1 min = 100 px)
					let minutes = ((time - this.firstItem.timestamp) / 1000) / 60;
					return (minutes * 100) - 71;
	            }
	        },
		}
    }
</script>
