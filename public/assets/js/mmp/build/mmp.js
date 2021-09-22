/**
 * @module mmp
 * @version 0.2.20
 * @file JavaScript library to draw mind maps.
 * @copyright Omar Desogus 2020
 * @license MIT
 * @see {@link https://github.com/Mindmapp/mmp|GitHub}
*/
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('d3')) :
  typeof define === 'function' && define.amd ? define(['exports', 'd3'], factory) :
  (factory((global.mmp = {}),global.d3));
}(this, (function (exports,d3) { 'use strict';

  var version = "0.2.20";

  /**
   * Manage console messages and errors.
   */
  var Log = /** @class */ (function () {
      function Log() {
      }
      /**
       * Throw an Error with a message.
       * @param {string} message
       * @param {string} type
       */
      Log.error = function (message, type) {
          switch (type) {
              case "eval":
                  throw new EvalError(message);
              case "range":
                  throw new RangeError(message);
              case "reference":
                  throw new ReferenceError(message);
              case "syntax":
                  throw new SyntaxError(message);
              case "type":
                  throw new TypeError(message);
              case "uri":
                  throw new URIError(message);
              default:
                  throw new Error(message);
          }
      };
      /**
       * Print an info message.
       * @param {string} message
       */
      Log.info = function (message) {
          console.log(message);
      };
      /**
       * Print a debug message.
       * @param {string} message
       */
      Log.debug = function (message) {
          console.debug(message);
      };
      return Log;
  }());

  /**
   * A list of general useful functions.
   */
  var Utils = /** @class */ (function () {
      function Utils() {
      }
      /**
       * Clone an object in depth.
       * @param {object} object
       * @returns object
       */
      Utils.cloneObject = function (object) {
          if (object === null) {
              return null;
          }
          else if (typeof object === "object") {
              return JSON.parse(JSON.stringify(object));
          }
          else {
              Log.error("Impossible to clone a non-object", "type");
          }
      };
      /**
       * Clear an object.
       * @param {object} object
       */
      Utils.clearObject = function (object) {
          for (var property in object) {
              delete object[property];
          }
      };
      /**
       * Convert an Object to an array.
       * @param {object} object
       * @returns {Array}
       */
      Utils.fromObjectToArray = function (object) {
          var array = [];
          for (var p in object) {
              array.push(object[p]);
          }
          return array;
      };
      /**
       * Merge two objects.
       * @param {object} object1
       * @param {object} object2
       * @param {boolean} restricted
       * @returns {object} result
       */
      Utils.mergeObjects = function (object1, object2, restricted) {
          if (restricted === void 0) { restricted = false; }
          if (object2 === undefined && this.isPureObjectType(object1)) {
              return this.cloneObject(object1);
          }
          else if (object1 === undefined && this.isPureObjectType(object2)) {
              return this.cloneObject(object2);
          }
          else if (!this.isPureObjectType(object1) || !this.isPureObjectType(object2)) {
              Log.error("Only two pure objects can be merged", "type");
          }
          var result = this.cloneObject(object1);
          for (var property in object2) {
              var value = object2[property];
              if (!restricted || result[property] !== undefined) {
                  if (this.isPrimitiveType(value) || value === null) {
                      result[property] = value;
                  }
                  else if (Array.isArray(value)) {
                      result[property] = Utils.cloneObject(value);
                  }
                  else if (this.isPureObjectType(value)) {
                      if (this.isPureObjectType(result[property])) {
                          result[property] = Utils.mergeObjects(result[property], value);
                      }
                      else {
                          result[property] = Utils.cloneObject(value);
                      }
                  }
                  else {
                      Log.error("Type \"" + typeof value + "\" not allowed here", "type");
                  }
              }
          }
          return result;
      };
      /**
       * Return css rules of an element.
       * @param {HTMLElement} element
       * @return {string} css
       */
      Utils.cssRules = function (element) {
          var css = "", sheets = document.styleSheets;
          for (var i = 0; i < sheets.length; i++) {
              var rules = sheets[i].cssRules;
              if (rules) {
                  for (var j = 0; j < rules.length; j++) {
                      var rule = rules[j], fontFace = rule.cssText.match(/^@font-face/);
                      if (element.querySelector(rule.selectorText) || fontFace) {
                          css += rule.cssText;
                      }
                  }
              }
          }
          return css;
      };
      /**
       * Return true if the value is a primitive type.
       * @param value
       * @returns {boolean}
       */
      Utils.isPrimitiveType = function (value) {
          return typeof value === "string" ||
              typeof value === "number" ||
              typeof value === "boolean" ||
              typeof value === "undefined";
      };
      /**
       * Return true if the value is a pure object.
       * @param value
       * @returns {boolean}
       */
      Utils.isPureObjectType = function (value) {
          return typeof value === "object" && !Array.isArray(value) && value !== null;
      };
      /**
       * Remove all ranges of window.
       */
      Utils.removeAllRanges = function () {
          window.getSelection().removeAllRanges();
      };
      /**
       * Focus an element putting the cursor in the end.
       * @param {HTMLElement} element
       */
      Utils.focusWithCaretAtEnd = function (element) {
          var range = document.createRange(), sel = window.getSelection();
          element.focus();
          range.selectNodeContents(element);
          range.collapse(false);
          sel.removeAllRanges();
          sel.addRange(range);
      };
      return Utils;
  }());

  /**
   * Manage the events of the map.
   */
  var Events = /** @class */ (function () {
      /**
       * Initialize the events.
       */
      function Events() {
          var _this = this;
          /**
           * Add a callback for specific map event.
           * @param {string} event
           * @param {Function} callback
           */
          this.on = function (event, callback) {
              if (typeof event !== "string") {
                  Log.error("The event must be a string", "type");
              }
              if (!Event[event]) {
                  Log.error("The event does not exist");
              }
              _this.dispatcher.on(Event[event], callback);
          };
          var events = Utils.fromObjectToArray(Event);
          this.dispatcher = d3.dispatch.apply(void 0, events);
      }
      /**
       * Call all registered callbacks for specified map event.
       * @param {Event} event
       * @param parameters
       */
      Events.prototype.call = function (event) {
          var parameters = [];
          for (var _i = 1; _i < arguments.length; _i++) {
              parameters[_i - 1] = arguments[_i];
          }
          var _a;
          return (_a = this.dispatcher).call.apply(_a, [event].concat(parameters));
      };
      return Events;
  }());
  var Event;
  (function (Event) {
      Event["create"] = "mmp-create";
      Event["center"] = "mmp-center";
      Event["undo"] = "mmp-undo";
      Event["redo"] = "mmp-redo";
      Event["exportJSON"] = "mmp-export-json";
      Event["exportImage"] = "mmp-export-image";
      Event["zoomIn"] = "mmp-zoom-in";
      Event["zoomOut"] = "mmp-zoom-out";
      Event["nodeSelect"] = "mmp-node-select";
      Event["nodeDeselect"] = "mmp-node-deselect";
      Event["nodeUpdate"] = "mmp-node-update";
      Event["nodeCreate"] = "mmp-node-create";
      Event["nodeRemove"] = "mmp-node-remove";
  })(Event || (Event = {}));

  /**
   * Manage the zoom events of the map.
   */
  var Zoom = /** @class */ (function () {
      /**
       * Get the associated map instance and initialize the d3 zoom behavior.
       * @param {Map} map
       */
      function Zoom(map) {
          var _this = this;
          /**
           * Zoom in the map.
           * @param {number} duration
           */
          this.zoomIn = function (duration) {
              if (duration && typeof duration !== "number") {
                  Log.error("The parameter must be a number", "type");
              }
              _this.move(true, duration);
              _this.map.events.call(Event.zoomIn);
          };
          /**
           * Zoom out the map.
           * @param {number} duration
           */
          this.zoomOut = function (duration) {
              if (duration && typeof duration !== "number") {
                  Log.error("The parameter must be a number", "type");
              }
              _this.move(false, duration);
              _this.map.events.call(Event.zoomOut);
          };
          /**
           * Center the root node in the mind map.
           * @param {number} duration
           * @param {number} type
           */
          this.center = function (type, duration) {
              if (duration === void 0) { duration = 500; }
              if (type && type !== "zoom" && type !== "position") {
                  Log.error("The type must be a string (\"zoom\" or \"position\")", "type");
              }
              if (duration && typeof duration !== "number") {
                  Log.error("The duration must be a number", "type");
              }
              var root = _this.map.nodes.getRoot(), w = _this.map.dom.container.node().clientWidth, h = _this.map.dom.container.node().clientHeight, x = w / 2 - root.coordinates.x, y = h / 2 - root.coordinates.y, svg = _this.map.dom.svg.transition().duration(duration);
              switch (type) {
                  case "zoom":
                      _this.zoomBehavior.scaleTo(svg, 1);
                      break;
                  case "position":
                      _this.zoomBehavior.translateTo(svg, w / 2 - x, h / 2 - y);
                      break;
                  default:
                      _this.zoomBehavior.transform(svg, d3.zoomIdentity.translate(x, y));
              }
              _this.map.events.call(Event.center);
          };
          this.map = map;
          this.zoomBehavior = d3.zoom().scaleExtent([0.5, 2]).on("zoom", function () {
              _this.map.dom.g.attr("transform", d3.event.transform);
          });
      }
      /**
       * Return the d3 zoom behavior.
       * @returns {ZoomBehavior} zoom
       */
      Zoom.prototype.getZoomBehavior = function () {
          return this.zoomBehavior;
      };
      /**
       * Move the zoom in a direction (true: in, false: out).
       * @param {boolean} direction
       * @param {number} duration
       */
      Zoom.prototype.move = function (direction, duration) {
          if (duration === void 0) { duration = 50; }
          var svg = this.map.dom.svg.transition().duration(duration);
          this.zoomBehavior.scaleBy(svg, direction ? 4 / 3 : 3 / 4);
      };
      return Zoom;
  }());

  /**
   * Draw the map and update it.
   */
  var Draw = /** @class */ (function () {
      /**
       * Get the associated map instance.
       * @param {Map} map
       */
      function Draw(map) {
          this.map = map;
      }
      /**
       * Create svg and main css map properties.
       */
      Draw.prototype.create = function () {
          var _this = this;
          this.map.dom.container = d3.select("#" + this.map.id)
              .style("position", "relative");
          this.map.dom.svg = this.map.dom.container.append("svg")
              .style("position", "absolute")
              .style("width", "100%")
              .style("height", "100%")
              .style("top", 0)
              .style("left", 0);
          this.map.dom.svg.append("rect")
              .attr("width", "100%")
              .attr("height", "100%")
              .attr("fill", "white")
              .attr("pointer-events", "all")
              .on("click", function () {
              // Deselect the selected node when click on the map background
              _this.map.nodes.deselectNode();
          });
          this.map.dom.g = this.map.dom.svg.append("g");
      };
      /**
       * Update the dom of the map with the (new) nodes.
       */
      Draw.prototype.update = function () {
          var _this = this;
          var nodes = this.map.nodes.getNodes(), dom = {
              nodes: this.map.dom.g.selectAll("." + this.map.id + "_node").data(nodes),
              branches: this.map.dom.g.selectAll("." + this.map.id + "_branch").data(nodes.slice(1))
          };
          var tapedTwice = false;
          var outer = dom.nodes.enter().append("g")
              .style("cursor", "pointer")
              .attr("class", this.map.id + "_node")
              .attr("id", function (node) {
              node.dom = this;
              return node.id;
          })
              .attr("transform", function (node) { return "translate(" + node.coordinates.x + "," + node.coordinates.y + ")"; })
              .on("dblclick", function (node) {
              d3.event.stopPropagation();
              _this.enableNodeNameEditing(node);
          }).on('touchstart', function (node) {
              if (!tapedTwice) {
                  tapedTwice = true;
                  setTimeout(function () {
                      tapedTwice = false;
                  }, 300);
                  return false;
              }
              _this.enableNodeNameEditing(node);
          });
          if (this.map.options.drag === true) {
              outer.call(this.map.drag.getDragBehavior());
          }
          else {
              outer.on("mousedown", function (node) {
                  _this.map.nodes.selectNode(node.id);
              });
          }
          // Set text of the node
          outer.insert("foreignObject")
              .html(function (node) { return _this.createNodeNameDOM(node); })
              .each(function (node) {
              _this.updateNodeNameContainer(node);
          });
          // Set background of the node
          outer.insert("path", "foreignObject")
              .style("fill", function (node) { return node.colors.background; })
              .style("stroke-width", 3)
              .attr("d", function (node) { return _this.drawNodeBackground(node); });
          // Set image of the node
          outer.each(function (node) {
              _this.setImage(node);
          });
          dom.branches.enter().insert("path", "g")
              .style("fill", function (node) { return node.colors.branch; })
              .style("stroke", function (node) { return node.colors.branch; })
              .attr("class", this.map.id + "_branch")
              .attr("id", function (node) { return node.id + "_branch"; })
              .attr("d", function (node) { return _this.drawBranch(node); });
          dom.nodes.exit().remove();
          dom.branches.exit().remove();
      };
      /**
       * Remove all nodes and branches of the map.
       */
      Draw.prototype.clear = function () {
          d3.selectAll("." + this.map.id + "_node, ." + this.map.id + "_branch").remove();
      };
      /**
       * Draw the background shape of the node.
       * @param {Node} node
       * @returns {Path} path
       */
      Draw.prototype.drawNodeBackground = function (node) {
          var name = node.getNameDOM(), path = d3.path();
          node.dimensions.width = name.clientWidth + 45;
          node.dimensions.height = name.clientHeight + 30;
          var x = node.dimensions.width / 2, y = node.dimensions.height / 2, k = node.k;
          path.moveTo(-x, k / 3);
          path.bezierCurveTo(-x, -y + 10, -x + 10, -y, k, -y);
          path.bezierCurveTo(x - 10, -y, x, -y + 10, x, k / 3);
          path.bezierCurveTo(x, y - 10, x - 10, y, k, y);
          path.bezierCurveTo(-x + 10, y, -x, y - 10, -x, k / 3);
          path.closePath();
          return path;
      };
      /**
       * Draw the branch of the node.
       * @param {Node} node
       * @returns {Path} path
       */
      Draw.prototype.drawBranch = function (node) {
          var parent = node.parent, path = d3.path(), level = node.getLevel(), width = 22 - (level < 6 ? level : 6) * 3, mx = (parent.coordinates.x + node.coordinates.x) / 2, ory = parent.coordinates.y < node.coordinates.y + node.dimensions.height / 2 ? -1 : 1, orx = parent.coordinates.x > node.coordinates.x ? -1 : 1, inv = orx * ory;
          path.moveTo(parent.coordinates.x, parent.coordinates.y - width * .8);
          path.bezierCurveTo(mx - width * inv, parent.coordinates.y - width / 2, parent.coordinates.x - width / 2 * inv, node.coordinates.y + node.dimensions.height / 2 - width / 3, node.coordinates.x - node.dimensions.width / 3 * orx, node.coordinates.y + node.dimensions.height / 2 + 3);
          path.bezierCurveTo(parent.coordinates.x + width / 2 * inv, node.coordinates.y + node.dimensions.height / 2 + width / 3, mx + width * inv, parent.coordinates.y + width / 2, parent.coordinates.x, parent.coordinates.y + width * .8);
          path.closePath();
          return path;
      };
      /**
       * Update the node HTML elements.
       * @param {Node} node
       */
      Draw.prototype.updateNodeShapes = function (node) {
          var _this = this;
          var background = node.getBackgroundDOM();
          d3.select(background).attr("d", function (node) { return _this.drawNodeBackground(node); });
          d3.selectAll("." + this.map.id + "_branch").attr("d", function (node) { return _this.drawBranch(node); });
          this.updateImagePosition(node);
          this.updateNodeNameContainer(node);
      };
      /**
       * Set main properties of node image and create it if it does not exist.
       * @param {Node} node
       */
      Draw.prototype.setImage = function (node) {
          var domImage = node.getImageDOM();
          if (!domImage) {
              domImage = document.createElementNS("http://www.w3.org/2000/svg", "image");
              node.dom.appendChild(domImage);
          }
          if (node.image.src !== "") {
              var image = new Image();
              image.src = node.image.src;
              image.onload = function () {
                  var h = node.image.size, w = this.width * h / this.height, y = -(h + node.dimensions.height / 2 + 5), x = -w / 2;
                  domImage.setAttribute("href", node.image.src);
                  domImage.setAttribute("height", h.toString());
                  domImage.setAttribute("width", w.toString());
                  domImage.setAttribute("y", y.toString());
                  domImage.setAttribute("x", x.toString());
              };
              image.onerror = function () {
                  domImage.remove();
                  node.image.src = "";
              };
          }
          else {
              domImage.remove();
          }
      };
      /**
       * Update the node image position.
       * @param {Node} node
       */
      Draw.prototype.updateImagePosition = function (node) {
          if (node.image.src !== "") {
              var image = node.getImageDOM(), y = -(image.getBBox().height + node.dimensions.height / 2 + 5);
              image.setAttribute("y", y.toString());
          }
      };
      /**
       * Enable and manage all events for the name editing.
       * @param {Node} node
       */
      Draw.prototype.enableNodeNameEditing = function (node) {
          var _this = this;
          var name = node.getNameDOM();
          Utils.focusWithCaretAtEnd(name);
          name.style.setProperty("cursor", "auto");
          name.ondblclick = name.onmousedown = function (event) {
              event.stopPropagation();
          };
          name.oninput = function () {
              _this.updateNodeShapes(node);
          };
          // Allow only some shortcuts.
          name.onkeydown = function (event) {
              // Unfocus the node.
              if (event.code === 'Escape') {
                  Utils.removeAllRanges();
                  name.blur();
              }
              if (event.ctrlKey || event.metaKey) {
                  switch (event.code) {
                      case 'KeyA':
                      case 'KeyC':
                      case 'KeyV':
                      case 'KeyX':
                      case 'KeyZ':
                      case 'ArrowLeft':
                      case 'ArrowRight':
                      case 'ArrowUp':
                      case 'ArrowDown':
                      case 'Backspace':
                      case 'Delete':
                          return true;
                      default:
                          return false;
                  }
              }
              switch (event.code) {
                  case 'Tab':
                      return false;
                  default:
                      return true;
              }
          };
          // Remove html formatting when paste text on node
          name.onpaste = function (event) {
              event.preventDefault();
              var text = event.clipboardData.getData("text/plain");
              document.execCommand("insertHTML", false, text);
          };
          name.onblur = function () {
              name.innerHTML = name.innerHTML === "<br>" ? "" : name.innerHTML;
              if (name.innerHTML !== node.name) {
                  _this.map.nodes.updateNode("name", name.innerHTML);
              }
              name.ondblclick = name.onmousedown = name.onblur =
                  name.onkeydown = name.oninput = name.onpaste = null;
              name.style.setProperty("cursor", "pointer");
              name.blur();
          };
      };
      /**
       * Update node name container (foreign object) dimensions.
       * @param {Node} node
       */
      Draw.prototype.updateNodeNameContainer = function (node) {
          var name = node.getNameDOM(), foreignObject = name.parentNode;
          if (name.offsetWidth !== 0) {
              foreignObject.setAttribute("x", (-name.clientWidth / 2).toString());
              foreignObject.setAttribute("y", (-name.clientHeight / 2).toString());
              foreignObject.setAttribute("width", name.clientWidth.toString());
              foreignObject.setAttribute("height", name.clientHeight.toString());
          }
      };
      /**
       * Create a string with HTML of the node name div.
       * @param {Node} node
       * @returns {string} html
       */
      Draw.prototype.createNodeNameDOM = function (node) {
          var div = document.createElement("div");
          div.style.setProperty("font-size", node.font.size.toString() + "px");
          div.style.setProperty("color", node.colors.name);
          div.style.setProperty("font-style", node.font.style);
          div.style.setProperty("font-weight", node.font.weight);
          div.style.setProperty("text-decoration", node.font.decoration);
          div.style.setProperty("display", "inline-block");
          div.style.setProperty("white-space", "pre");
          div.style.setProperty("font-family", this.map.options.fontFamily);
          div.style.setProperty("text-align", "center");
          div.setAttribute("contenteditable", "true");
          div.innerHTML = node.name;
          return div.outerHTML;
      };
      return Draw;
  }());

  /**
   * Manage default map options.
   */
  var Options = /** @class */ (function () {
      /**
       * Initialize all options.
       * @param {OptionParameters} parameters
       * @param {Map} map
       */
      function Options(parameters, map) {
          if (parameters === void 0) { parameters = {}; }
          var _this = this;
          this.update = function (property, value) {
              if (typeof property !== "string") {
                  Log.error("The property must be a string", "type");
              }
              switch (property) {
                  case "fontFamily":
                      _this.updateFontFamily(value);
                      break;
                  case "centerOnResize":
                      _this.updateCenterOnResize(value);
                      break;
                  case "drag":
                      _this.updateDrag(value);
                      break;
                  case "zoom":
                      _this.updateZoom(value);
                      break;
                  case "defaultNode":
                      _this.updateDefaultNode(value);
                      break;
                  case "rootNode":
                      _this.updateDefaultRootNode(value);
                      break;
                  default:
                      Log.error("The property does not exist");
              }
          };
          this.map = map;
          this.fontFamily = parameters.fontFamily || "Arial, Helvetica, sans-serif";
          this.centerOnResize = parameters.centerOnResize !== undefined ? parameters.centerOnResize : true;
          this.drag = parameters.drag !== undefined ? parameters.drag : true;
          this.zoom = parameters.zoom !== undefined ? parameters.zoom : true;
          // Default node properties
          this.defaultNode = Utils.mergeObjects({
              name: "Node",
              image: {
                  src: "",
                  size: 60
              },
              colors: {
                  name: "#787878",
                  background: "#f9f9f9",
                  branch: "#577a96"
              },
              font: {
                  size: 16,
                  style: "normal",
                  weight: "normal"
              },
              locked: true
          }, parameters.defaultNode, true);
          // Default root node properties
          this.rootNode = Utils.mergeObjects({
              name: "Root node",
              image: {
                  src: "",
                  size: 70
              },
              colors: {
                  name: "#787878",
                  background: "#f0f6f5",
                  branch: ""
              },
              font: {
                  size: 20,
                  style: "normal",
                  weight: "normal"
              }
          }, parameters.rootNode, true);
      }
      /**
       * Update the font family of all nodes.
       * @param {string} font
       */
      Options.prototype.updateFontFamily = function (font) {
          if (typeof font !== "string") {
              Log.error("The font must be a string", "type");
          }
          this.fontFamily = font;
          this.map.draw.update();
      };
      /**
       * Update centerOnResize behavior.
       * @param {boolean} flag
       */
      Options.prototype.updateCenterOnResize = function (flag) {
          var _this = this;
          if (typeof flag !== "boolean") {
              Log.error("The value must be a boolean", "type");
          }
          this.centerOnResize = flag;
          if (this.centerOnResize === true) {
              d3.select(window).on("resize." + this.map.id, function () {
                  _this.map.zoom.center();
              });
          }
          else {
              d3.select(window).on("resize." + this.map.id, null);
          }
      };
      /**
       * Update drag behavior.
       * @param {boolean} flag
       */
      Options.prototype.updateDrag = function (flag) {
          if (typeof flag !== "boolean") {
              Log.error("The value must be a boolean", "type");
          }
          this.drag = flag;
          this.map.draw.clear();
          this.map.draw.update();
      };
      /**
       * Update zoom behavior.
       * @param {boolean} flag
       */
      Options.prototype.updateZoom = function (flag) {
          if (typeof flag !== "boolean") {
              Log.error("The value must be a boolean", "type");
          }
          this.zoom = flag;
          if (this.zoom === true) {
              this.map.dom.svg.call(this.map.zoom.getZoomBehavior());
          }
          else {
              this.map.dom.svg.on(".zoom", null);
          }
      };
      /**
       * Update default node properties.
       * @param {DefaultNodeProperties} properties
       */
      Options.prototype.updateDefaultNode = function (properties) {
          this.defaultNode = Utils.mergeObjects(this.defaultNode, properties, true);
      };
      /**
       * Update default root node properties.
       * @param {DefaultNodeProperties} properties
       */
      Options.prototype.updateDefaultRootNode = function (properties) {
          this.rootNode = Utils.mergeObjects(this.rootNode, properties, true);
      };
      return Options;
  }());

  /**
   * Model of the nodes.
   */
  var Node = /** @class */ (function () {
      /**
       * Initialize the node properties, the dimensions and the k coefficient.
       * @param {NodeProperties} properties
       */
      function Node(properties) {
          this.id = properties.id;
          this.parent = properties.parent;
          this.name = properties.name;
          this.coordinates = properties.coordinates;
          this.colors = properties.colors;
          this.image = properties.image;
          this.font = properties.font;
          this.locked = properties.locked;
          this.dimensions = {
              width: 0,
              height: 0
          };
          this.k = properties.k || d3.randomUniform(-20, 20)();
      }
      /**
       * Return true if the node is the root or false.
       * @returns {boolean}
       */
      Node.prototype.isRoot = function () {
          var words = this.id.split("_");
          return words[words.length - 1] === "0";
      };
      /**
       * Return the level of the node.
       * @returns {number} level
       */
      Node.prototype.getLevel = function () {
          var level = 1, parent = this.parent;
          while (parent) {
              level++;
              parent = parent.parent;
          }
          return level;
      };
      /**
       * Return the div element of the node name.
       * @returns {HTMLDivElement} div
       */
      Node.prototype.getNameDOM = function () {
          return this.dom.querySelector("foreignObject > div");
      };
      /**
       * Return the SVG path of the node background.
       * @returns {SVGPathElement} path
       */
      Node.prototype.getBackgroundDOM = function () {
          return this.dom.querySelector("path");
      };
      /**
       * Return the SVG image of the node image.
       * @returns {SVGImageElement} image
       */
      Node.prototype.getImageDOM = function () {
          return this.dom.querySelector("image");
      };
      return Node;
  }());

  /**
   * Manage map history, for each change save a snapshot.
   */
  var History = /** @class */ (function () {
      /**
       * Get the associated map instance, initialize index and snapshots.
       * @param {Map} map
       */
      function History(map) {
          var _this = this;
          /**
           * Return last snapshot of the current map.
           * @return {MapSnapshot} [snapshot] - Last snapshot of the map.
           */
          this.current = function () {
              return _this.snapshots[_this.index];
          };
          /**
           * Replace old map with a new one or create a new empty map.
           * @param {MapSnapshot} snapshot
           */
          this.new = function (snapshot) {
              if (snapshot === undefined) {
                  var oldRootCoordinates = Utils.cloneObject(_this.map.nodes.getRoot().coordinates);
                  _this.map.nodes.setCounter(0);
                  _this.map.nodes.clear();
                  _this.map.draw.clear();
                  _this.map.draw.update();
                  _this.map.nodes.addRootNode(oldRootCoordinates);
                  _this.map.zoom.center(null, 0);
                  _this.save();
                  _this.map.events.call(Event.create);
              }
              else if (_this.checkSnapshotStructure(snapshot)) {
                  _this.redraw(snapshot);
                  _this.map.zoom.center("position", 0);
                  _this.save();
                  _this.map.events.call(Event.create);
              }
              else {
                  Log.error("The snapshot is not correct");
              }
          };
          /**
           * Undo last changes.
           */
          this.undo = function () {
              if (_this.index > 0) {
                  _this.redraw(_this.snapshots[--_this.index]);
                  _this.map.events.call(Event.undo);
              }
          };
          /**
           * Redo one change which was undone.
           */
          this.redo = function () {
              if (_this.index < _this.snapshots.length - 1) {
                  _this.redraw(_this.snapshots[++_this.index]);
                  _this.map.events.call(Event.redo);
              }
          };
          /**
           * Return all history of map with all snapshots.
           * @returns {MapSnapshot[]}
           */
          this.getHistory = function () {
              return {
                  snapshots: _this.snapshots.slice(0),
                  index: _this.index
              };
          };
          this.map = map;
          this.index = -1;
          this.snapshots = [];
      }
      /**
       * Save the current snapshot of the mind map.
       */
      History.prototype.save = function () {
          if (this.index < this.snapshots.length - 1) {
              this.snapshots.splice(this.index + 1);
          }
          this.snapshots.push(this.getSnapshot());
          this.index++;
      };
      /**
       * Redraw the map with a new snapshot.
       * @param {MapSnapshot} snapshot
       */
      History.prototype.redraw = function (snapshot) {
          var _this = this;
          this.map.nodes.clear();
          snapshot.forEach(function (property) {
              var properties = {
                  id: _this.sanitizeNodeId(property.id),
                  parent: _this.map.nodes.getNode(_this.sanitizeNodeId(property.parent)),
                  k: property.k,
                  name: property.name,
                  coordinates: Utils.cloneObject(property.coordinates),
                  image: Utils.cloneObject(property.image),
                  colors: Utils.cloneObject(property.colors),
                  font: Utils.cloneObject(property.font),
                  locked: property.locked
              };
              var node = new Node(properties);
              _this.map.nodes.setNode(node.id, node);
          });
          this.map.draw.clear();
          this.map.draw.update();
          this.map.nodes.selectRootNode();
          this.setCounter();
      };
      /**
       * Return a copy of all fundamental node properties.
       * @return {MapSnapshot} properties
       */
      History.prototype.getSnapshot = function () {
          var _this = this;
          return this.map.nodes.getNodes().map(function (node) {
              return _this.map.nodes.getNodeProperties(node, false);
          }).slice();
      };
      /**
       * Set the right counter value of the nodes.
       */
      History.prototype.setCounter = function () {
          var id = this.map.nodes.getNodes().map(function (node) {
              var words = node.id.split("_");
              return parseInt(words[words.length - 1]);
          });
          this.map.nodes.setCounter(Math.max.apply(Math, id) + 1);
      };
      /**
       * Sanitize an old map node id with a new.
       * @param {string} oldId
       * @returns {string} newId
       */
      History.prototype.sanitizeNodeId = function (oldId) {
          if (typeof oldId === "string") {
              var words = oldId.split("_");
              return this.map.id + "_" + words[words.length - 2] + "_" + words[words.length - 1];
          }
      };
      /**
       * Check the snapshot structure and return true if it is authentic.
       * @param {MapSnapshot} snapshot
       * @return {boolean} result
       */
      History.prototype.checkSnapshotStructure = function (snapshot) {
          if (!Array.isArray(snapshot)) {
              return false;
          }
          if ((snapshot[0].key && snapshot[0].value)) {
              this.convertOldMmp(snapshot);
          }
          for (var _i = 0, snapshot_1 = snapshot; _i < snapshot_1.length; _i++) {
              var node = snapshot_1[_i];
              if (!this.checkNodeProperties(node)) {
                  return false;
              }
          }
          this.translateNodePositions(snapshot);
          return true;
      };
      /**
       * Check the snapshot node properties and return true if they are authentic.
       * @param {ExportNodeProperties} node
       * @return {boolean} result
       */
      History.prototype.checkNodeProperties = function (node) {
          var conditions = [
              typeof node.id === "string",
              typeof node.parent === "string",
              typeof node.k === "number",
              typeof node.name === "string",
              typeof node.locked === "boolean",
              node.coordinates
                  && typeof node.coordinates.x === "number"
                  && typeof node.coordinates.y === "number",
              node.image
                  && typeof node.image.size === "number"
                  && typeof node.image.src === "string",
              node.colors
                  && typeof node.colors.background === "string"
                  && typeof node.colors.branch === "string"
                  && typeof node.colors.name === "string",
              node.font
                  && typeof node.font.size === "number"
                  && typeof node.font.weight === "string"
                  && typeof node.font.style === "string"
          ];
          return conditions.every(function (condition) { return condition; });
      };
      /**
       * Convert the old mmp (version: 0.1.7) snapshot to new.
       * @param {Array} snapshot
       */
      History.prototype.convertOldMmp = function (snapshot) {
          for (var _i = 0, snapshot_2 = snapshot; _i < snapshot_2.length; _i++) {
              var node = snapshot_2[_i];
              var oldNode = Utils.cloneObject(node);
              Utils.clearObject(node);
              node.id = "map_node_" + oldNode.key.substr(4);
              node.parent = oldNode.value.parent ? "map_node_" + oldNode.value.parent.substr(4) : "";
              node.k = oldNode.value.k;
              node.name = oldNode.value.name;
              node.locked = oldNode.value.fixed;
              node.coordinates = {
                  x: oldNode.value.x,
                  y: oldNode.value.y
              };
              node.image = {
                  size: parseInt(oldNode.value["image-size"]),
                  src: oldNode.value["image-src"]
              };
              node.colors = {
                  background: oldNode.value["background-color"],
                  branch: oldNode.value["branch-color"] || "",
                  name: oldNode.value["text-color"]
              };
              node.font = {
                  size: parseInt(oldNode.value["font-size"]),
                  weight: oldNode.value.bold ? "bold" : "normal",
                  style: oldNode.value.italic ? "italic" : "normal"
              };
          }
      };
      /**
       * Adapt the coordinates to the old map.
       * @param {MapSnapshot} snapshot
       */
      History.prototype.translateNodePositions = function (snapshot) {
          var oldRootNode = this.map.nodes.getRoot(), newRootNode = snapshot.find(function (node) {
              var words = node.id.split("_");
              return words[words.length - 1] === "0";
          }), dx = newRootNode.coordinates.x - oldRootNode.coordinates.x, dy = newRootNode.coordinates.y - oldRootNode.coordinates.y;
          for (var _i = 0, snapshot_3 = snapshot; _i < snapshot_3.length; _i++) {
              var node = snapshot_3[_i];
              node.coordinates.x -= dx;
              node.coordinates.y -= dy;
          }
      };
      return History;
  }());

  /**
   * Manage the drag events of the nodes.
   */
  var Drag = /** @class */ (function () {
      /**
       * Get the associated map instance and initialize the d3 drag behavior.
       * @param {Map} map
       */
      function Drag(map) {
          var _this = this;
          this.map = map;
          this.dragBehavior = d3.drag()
              .on("start", function (node) { return _this.started(node); })
              .on("drag", function (node) { return _this.dragged(node); })
              .on("end", function (node) { return _this.ended(node); });
      }
      /**
       * Return the d3 drag behavior
       * @returns {DragBehavior} dragBehavior
       */
      Drag.prototype.getDragBehavior = function () {
          return this.dragBehavior;
      };
      /**
       * Select the node and calculate node position data for dragging.
       * @param {Node} node
       */
      Drag.prototype.started = function (node) {
          d3.event.sourceEvent.preventDefault();
          this.orientation = this.map.nodes.getOrientation(node);
          this.descendants = this.map.nodes.getDescendants(node);
          this.map.nodes.selectNode(node.id);
      };
      /**
       * Move the dragged node and if it is locked all their descendants.
       * @param {Node} node
       */
      Drag.prototype.dragged = function (node) {
          var _this = this;
          var dy = d3.event.dy, dx = d3.event.dx;
          // Set new coordinates
          var x = node.coordinates.x += dx, y = node.coordinates.y += dy;
          // Move graphically the node in new coordinates
          node.dom.setAttribute("transform", "translate(" + [x, y] + ")");
          // If the node is locked move also descendants
          if (node.locked) {
              // Check if old and new orientation are equal
              var newOrientation = this.map.nodes.getOrientation(node), orientationIsChanged = newOrientation !== this.orientation, root = node;
              for (var _i = 0, _a = this.descendants; _i < _a.length; _i++) {
                  var node_1 = _a[_i];
                  var x_1 = node_1.coordinates.x += dx, y_1 = node_1.coordinates.y += dy;
                  if (orientationIsChanged) {
                      x_1 = node_1.coordinates.x += (root.coordinates.x - node_1.coordinates.x) * 2;
                  }
                  node_1.dom.setAttribute("transform", "translate(" + [x_1, y_1] + ")");
              }
              if (orientationIsChanged) {
                  this.orientation = newOrientation;
              }
          }
          // Update all mind map branches
          d3.selectAll("." + this.map.id + "_branch").attr("d", function (node) {
              return _this.map.draw.drawBranch(node);
          });
          // This is here and not in the started function because started function
          // is also executed when there is no drag events
          this.dragging = true;
      };
      /**
       * If the node was actually dragged change the state of dragging and save the snapshot.
       * @param {Node} node
       */
      Drag.prototype.ended = function (node) {
          if (this.dragging) {
              this.dragging = false;
              this.map.history.save();
              this.map.events.call(Event.nodeUpdate, node.dom, this.map.nodes.getNodeProperties(node));
          }
      };
      return Drag;
  }());

  /**
   * Manage the nodes of the map.
   */
  var Nodes = /** @class */ (function () {
      /**
       * Get the associated map instance and initialize counter and nodes.
       * @param {Map} map
       */
      function Nodes(map) {
          var _this = this;
          /**
           * Add a node in the map.
           * @param {UserNodeProperties} userProperties
           * @param {string} id
           */
          this.addNode = function (userProperties, id) {
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var parentNode = id ? _this.getNode(id) : _this.selectedNode;
              if (parentNode === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              var properties = Utils.mergeObjects(_this.map.options.defaultNode, userProperties, true);
              properties.id = _this.map.id + "_node_" + _this.counter + "_" + userProperties.user_id;
              properties.parent = parentNode;
              var node = new Node(properties);
              _this.nodes.set(properties.id, node);
              _this.counter++;
              // Set coordinates
              node.coordinates = _this.calculateCoordinates(node);
              if (userProperties && userProperties.coordinates) {
                  var fixedCoordinates = _this.fixCoordinates(userProperties.coordinates);
                  node.coordinates = Utils.mergeObjects(node.coordinates, fixedCoordinates, true);
              }
              _this.map.draw.update();
              _this.map.history.save();
              _this.map.events.call(Event.nodeCreate, node.dom, _this.getNodeProperties(node));
          };
          /**
           * Select a node or return the current selected node.
           * @param {string} id
           * @returns {ExportNodeProperties}
           */
          this.selectNode = function (id) {
              if (id !== undefined) {
                  if (typeof id !== "string") {
                      Log.error("The node id must be a string", "type");
                  }
                  if (!_this.nodeSelectionTo(id)) {
                      if (_this.nodes.has(id)) {
                          var node = _this.nodes.get(id), background = node.getBackgroundDOM();
                          if (!background.style.stroke) {
                              if (_this.selectedNode) {
                                  _this.selectedNode.getBackgroundDOM().style.stroke = "";
                              }
                              var color = d3.color(background.style.fill).darker(.5);
                              background.style.stroke = color.toString();
                              Utils.removeAllRanges();
                              _this.selectedNode.getNameDOM().blur();
                              _this.selectedNode = node;
                              _this.map.events.call(Event.nodeSelect, node.dom, _this.getNodeProperties(node));
                          }
                      }
                      else {
                          Log.error("The node id or the direction is not correct");
                      }
                  }
              }
              return _this.getNodeProperties(_this.selectedNode);
          };
          /**
           * Enable the node name editing of the selected node.
           */
          this.editNode = function () {
              if (_this.selectedNode) {
                  _this.map.draw.enableNodeNameEditing(_this.selectedNode);
              }
          };
          /**
           * Deselect the current selected node.
           */
          this.deselectNode = function () {
              if (_this.selectedNode) {
                  _this.selectedNode.getBackgroundDOM().style.stroke = "";
                  Utils.removeAllRanges();
              }
              _this.selectRootNode();
              _this.map.events.call(Event.nodeDeselect);
          };
          /**
           * Update the properties of the selected node.
           * @param {string} property
           * @param value
           * @param {string} id
           * @param {boolean} graphic
           */
          this.updateNode = function (property, value, graphic, id) {
              if (graphic === void 0) { graphic = false; }
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.getNode(id) : _this.selectedNode;
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              if (typeof property !== "string") {
                  Log.error("The property must be a string", "type");
              }
              var updated;
              switch (property) {
                  case "name":
                      updated = _this.updateNodeName(_this.selectedNode, value, graphic);
                      break;
                  case "locked":
                      updated = _this.updateNodeLockedStatus(_this.selectedNode, value);
                      break;
                  case "coordinates":
                      updated = _this.updateNodeCoordinates(_this.selectedNode, value);
                      break;
                  case "imageSrc":
                      updated = _this.updateNodeImageSrc(_this.selectedNode, value);
                      break;
                  case "imageSize":
                      updated = _this.updateNodeImageSize(_this.selectedNode, value, graphic);
                      break;
                  case "backgroundColor":
                      updated = _this.updateNodeBackgroundColor(_this.selectedNode, value, graphic);
                      break;
                  case "branchColor":
                      updated = _this.updateNodeBranchColor(_this.selectedNode, value, graphic);
                      break;
                  case "fontWeight":
                      updated = _this.updateNodeFontWeight(_this.selectedNode, value, graphic);
                      break;
                  case "textDecoration":
                      updated = _this.updateNodeTextDecoration(_this.selectedNode, value, graphic);
                      break;
                  case "fontStyle":
                      updated = _this.updateNodeFontStyle(_this.selectedNode, value, graphic);
                      break;
                  case "fontSize":
                      updated = _this.updateNodeFontSize(_this.selectedNode, value, graphic);
                      break;
                  case "nameColor":
                      updated = _this.updateNodeNameColor(_this.selectedNode, value, graphic);
                      break;
                  default:
                      Log.error("The property does not exist");
              }
              if (graphic === false && updated !== false) {
                  _this.map.history.save();
                  _this.map.events.call(Event.nodeUpdate, _this.selectedNode.dom, _this.getNodeProperties(_this.selectedNode));
              }
          };
          /**
           * Remove the selected node.
           * @param {string} id
           */
          this.removeNode = function (id) {
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.getNode(id) : _this.selectedNode;
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              if (!node.isRoot()) {
                  _this.nodes.remove(node.id);
                  _this.getDescendants(node).forEach(function (node) {
                      _this.nodes.remove(node.id);
                  });
                  _this.map.draw.clear();
                  _this.map.draw.update();
                  _this.map.history.save();
                  _this.map.events.call(Event.nodeRemove, null, _this.getNodeProperties(node));
                  _this.deselectNode();
              }
              else {
                  Log.error("The root node can not be deleted");
              }
          };
          /**
           * Return the blog of the node.
           * @param {string} id
           * @returns {ExportNodeProperties[]}
           */
          this.nodeChildren = function (id) {
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.getNode(id) : _this.selectedNode;
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              return _this.nodes.values().filter(function (n) {
                  return n.parent && n.parent.id === node.id;
              }).map(function (n) {
                  return _this.getNodeProperties(n);
              });
          };
          /**
           * Update the node name with a new value.
           * @param {Node} node
           * @param {string} name
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeName = function (node, name, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (name && typeof name !== "string") {
                  Log.error("The name must be a string", "type");
              }
              if (node.name != name || graphic) {
                  node.getNameDOM().innerHTML = name;
                  _this.map.draw.updateNodeShapes(node);
                  if (graphic === false) {
                      node.name = name;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node coordinates with a new value.
           * @param {Node} node
           * @param {Coordinates} coordinates
           * @returns {boolean}
           */
          this.updateNodeCoordinates = function (node, coordinates) {
              var fixedCoordinates = _this.fixCoordinates(coordinates);
              coordinates = Utils.mergeObjects(node.coordinates, fixedCoordinates, true);
              if (!(coordinates.x === node.coordinates.x && coordinates.y === node.coordinates.y)) {
                  var oldOrientation = _this.getOrientation(_this.selectedNode), dx = node.coordinates.x - coordinates.x, dy = node.coordinates.y - coordinates.y;
                  node.coordinates = Utils.cloneObject(coordinates);
                  node.dom.setAttribute("transform", "translate(" + [coordinates.x, coordinates.y] + ")");
                  // If the node is locked move also descendants
                  if (_this.selectedNode.locked) {
                      var root = _this.selectedNode, descendants = _this.getDescendants(_this.selectedNode), newOrientation = _this.getOrientation(_this.selectedNode);
                      for (var _i = 0, descendants_1 = descendants; _i < descendants_1.length; _i++) {
                          var node_1 = descendants_1[_i];
                          var x = node_1.coordinates.x -= dx, y = node_1.coordinates.y -= dy;
                          if (oldOrientation !== newOrientation) {
                              x = node_1.coordinates.x += (root.coordinates.x - node_1.coordinates.x) * 2;
                          }
                          node_1.dom.setAttribute("transform", "translate(" + [x, y] + ")");
                      }
                  }
                  d3.selectAll("." + _this.map.id + "_branch").attr("d", function (node) {
                      return _this.map.draw.drawBranch(node);
                  });
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node background color with a new value.
           * @param {Node} node
           * @param {string} color
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeBackgroundColor = function (node, color, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (color && typeof color !== "string") {
                  Log.error("The background color must be a string", "type");
              }
              if (node.colors.background !== color || graphic) {
                  var background = node.getBackgroundDOM();
                  background.style["fill"] = color;
                  if (background.style["stroke"] !== "") {
                      background.style["stroke"] = d3.color(color).darker(.5).toString();
                  }
                  if (graphic === false) {
                      node.colors.background = color;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node text color with a new value.
           * @param {Node} node
           * @param {string} color
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeNameColor = function (node, color, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (color && typeof color !== "string") {
                  Log.error("The text color must be a string", "type");
              }
              if (node.colors.name !== color || graphic) {
                  node.getNameDOM().style["color"] = color;
                  if (graphic === false) {
                      node.colors.name = color;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node branch color with a new value.
           * @param {Node} node
           * @param {string} color
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeBranchColor = function (node, color, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (color && typeof color !== "string") {
                  Log.error("The branch color must be a string", "type");
              }
              if (!node.isRoot()) {
                  if (node.colors.name !== color || graphic) {
                      var branch = document.getElementById(node.id + "_branch");
                      branch.style["fill"] = branch.style["stroke"] = color;
                      if (graphic === false) {
                          node.colors.branch = color;
                      }
                  }
                  else {
                      return false;
                  }
              }
              else {
                  Log.error("The root node has no branches");
              }
          };
          /**
           * Update the node font size with a new value.
           * @param {Node} node
           * @param {number} size
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeFontSize = function (node, size, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (size && typeof size !== "number") {
                  Log.error("The font size must be a number", "type");
              }
              if (node.font.size != size || graphic) {
                  node.getNameDOM().style["font-size"] = size + "px";
                  _this.map.draw.updateNodeShapes(node);
                  if (graphic === false) {
                      node.font.size = size;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node image size with a new value.
           * @param {Node} node
           * @param {number} size
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeImageSize = function (node, size, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (size && typeof size !== "number") {
                  Log.error("The image size must be a number", "type");
              }
              if (node.image.src !== "") {
                  if (node.image.size !== size || graphic) {
                      var image = node.getImageDOM(), box = image.getBBox(), height = size, width = box.width * height / box.height, y = -(height + node.dimensions.height / 2 + 5), x = -width / 2;
                      image.setAttribute("height", height.toString());
                      image.setAttribute("width", width.toString());
                      image.setAttribute("y", y.toString());
                      image.setAttribute("x", x.toString());
                      if (graphic === false) {
                          node.image.size = height;
                      }
                  }
                  else {
                      return false;
                  }
              }
              else
                  Log.error("The node does not have an image");
          };
          /**
           * Update the node image src with a new value.
           * @param {Node} node
           * @param {string} src
           * @returns {boolean}
           */
          this.updateNodeImageSrc = function (node, src) {
              if (src && typeof src !== "string") {
                  Log.error("The image path must be a string", "type");
              }
              if (node.image.src !== src) {
                  node.image.src = src;
                  _this.map.draw.setImage(node);
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node font style.
           * @param {Node} node
           * @param {string} style
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeFontStyle = function (node, style, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (style && typeof style !== "string") {
                  Log.error("The font style must be a string", "type");
              }
              if (node.font.style !== style) {
                  node.getNameDOM().style["font-style"] = style;
                  if (graphic === false) {
                      node.font.style = style;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node font weight.
           * @param {Node} node
           * @param {string} weight
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeFontWeight = function (node, weight, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (weight && typeof weight !== "string") {
                  Log.error("The font weight must be a string", "type");
              }
              if (node.font.weight !== weight) {
                  node.getNameDOM().style["font-weight"] = weight;
                  _this.map.draw.updateNodeShapes(node);
                  if (graphic === false) {
                      node.font.weight = weight;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node text decoration.
           * @param {Node} node
           * @param {string} decoration
           * @param {boolean} graphic
           * @returns {boolean}
           */
          this.updateNodeTextDecoration = function (node, decoration, graphic) {
              if (graphic === void 0) { graphic = false; }
              if (decoration && typeof decoration !== "string") {
                  Log.error("The text decoration must be a string", "type");
              }
              if (node.font.decoration !== decoration) {
                  node.getNameDOM().style["text-decoration"] = decoration;
                  _this.map.draw.updateNodeShapes(node);
                  if (graphic === false) {
                      node.font.decoration = decoration;
                  }
              }
              else {
                  return false;
              }
          };
          /**
           * Update the node locked status.
           * @param {Node} node
           * @param {boolean} flag
           * @returns {boolean}
           */
          this.updateNodeLockedStatus = function (node, flag) {
              if (flag && typeof flag !== "boolean") {
                  Log.error("The node locked status must be a boolean", "type");
              }
              if (!node.isRoot()) {
                  node.locked = flag || !node.locked;
              }
              else {
                  Log.error("The root node can not be locked");
              }
          };
          this.map = map;
          this.counter = 0;
          this.nodes = d3.map();
      }
      /**
       * Add the root node to the map.
       * @param {Coordinates} coordinates
       */
      Nodes.prototype.addRootNode = function (coordinates) {
          var properties = Utils.mergeObjects(this.map.options.rootNode, {
              coordinates: {
                  x: this.map.dom.container.node().clientWidth / 2,
                  y: this.map.dom.container.node().clientHeight / 2
              },
              locked: false,
              id: this.map.id + "_node_" + this.counter,
              parent: null
          });
          var node = new Node(properties);
          if (coordinates) {
              node.coordinates.x = coordinates.x || node.coordinates.x;
              node.coordinates.y = coordinates.y || node.coordinates.y;
          }
          this.nodes.set(properties.id, node);
          this.counter++;
          this.map.draw.update();
          this.selectRootNode();
      };
      /**
       * Return the export properties of the node.
       * @param {Node} node
       * @param {boolean} fixedCoordinates
       * @returns {ExportNodeProperties} properties
       */
      Nodes.prototype.getNodeProperties = function (node, fixedCoordinates) {
          if (fixedCoordinates === void 0) { fixedCoordinates = true; }
          return {
              id: node.id,
              parent: node.parent ? node.parent.id : "",
              name: node.name,
              coordinates: fixedCoordinates
                  ? this.fixCoordinates(node.coordinates, true)
                  : Utils.cloneObject(node.coordinates),
              image: Utils.cloneObject(node.image),
              colors: Utils.cloneObject(node.colors),
              font: Utils.cloneObject(node.font),
              locked: node.locked,
              k: node.k
          };
      };
      /**
       * Convert external coordinates to internal or otherwise.
       * @param {Coordinates} coordinates
       * @param {boolean} reverse
       * @returns {Coordinates}
       */
      Nodes.prototype.fixCoordinates = function (coordinates, reverse) {
          if (reverse === void 0) { reverse = false; }
          var zoomCoordinates = d3.zoomTransform(this.map.dom.svg.node()), fixedCoordinates = {};
          if (coordinates.x) {
              if (reverse === false) {
                  fixedCoordinates.x = (coordinates.x - zoomCoordinates.x) / zoomCoordinates.k;
              }
              else {
                  fixedCoordinates.x = coordinates.x * zoomCoordinates.k + zoomCoordinates.x;
              }
          }
          if (coordinates.y) {
              if (reverse === false) {
                  fixedCoordinates.y = (coordinates.y - zoomCoordinates.y) / zoomCoordinates.k;
              }
              else {
                  fixedCoordinates.y = coordinates.y * zoomCoordinates.k + zoomCoordinates.y;
              }
          }
          return fixedCoordinates;
      };
      /**
       * Move the node selection in the direction passed as parameter.
       * @param {string} direction
       * @returns {boolean}
       */
      Nodes.prototype.nodeSelectionTo = function (direction) {
          switch (direction) {
              case "up":
                  this.moveSelectionOnLevel(true);
                  return true;
              case "down":
                  this.moveSelectionOnLevel(false);
                  return true;
              case "left":
                  this.moveSelectionOnBranch(true);
                  return true;
              case "right":
                  this.moveSelectionOnBranch(false);
                  return true;
              default:
                  return false;
          }
      };
      /**
       * Return the blog of a node.
       * @param {Node} node
       * @returns {Node[]}
       */
      Nodes.prototype.getChildren = function (node) {
          return this.nodes.values().filter(function (n) {
              return n.parent && n.parent.id === node.id;
          });
      };
      /**
       * Return the orientation of a node in the map (true if left).
       * @return {boolean}
       */
      Nodes.prototype.getOrientation = function (node) {
          if (!node.isRoot()) {
              return node.coordinates.x < this.getRoot().coordinates.x;
          }
      };
      /**
       * Return the root node.
       * @returns {Node} rootNode
       */
      Nodes.prototype.getRoot = function () {
          return this.nodes.get(this.map.id + "_node_0");
      };
      /**
       * Return all descendants of a node.
       * @returns {Node[]} nodes
       */
      Nodes.prototype.getDescendants = function (node) {
          var _this = this;
          var nodes = [];
          this.getChildren(node).forEach(function (node) {
              nodes.push(node);
              nodes = nodes.concat(_this.getDescendants(node));
          });
          return nodes;
      };
      /**
       * Return an array of all nodes.
       * @returns {Node[]}
       */
      Nodes.prototype.getNodes = function () {
          return this.nodes.values();
      };
      /**
       * Return the node with the id equal to id passed as parameter.
       * @param {string} id
       * @returns {Node}
       */
      Nodes.prototype.getNode = function (id) {
          return this.nodes.get(id);
      };
      /**
       * Set a node as a id-value copy.
       * @param {string} key
       * @param {Node} node
       */
      Nodes.prototype.setNode = function (key, node) {
          this.nodes.set(key, node);
      };
      /**
       * Get the counter number of the nodes.
       * @returns {number} counter
       */
      Nodes.prototype.getCounter = function () {
          return this.counter;
      };
      /**
       * Set the counter of the nodes.
       * @param {number} number
       */
      Nodes.prototype.setCounter = function (number) {
          this.counter = number;
      };
      /**
       * Return the current selected node.
       * @returns {Node}
       */
      Nodes.prototype.getSelectedNode = function () {
          return this.selectedNode;
      };
      /**
       * Set the root node as selected node.
       */
      Nodes.prototype.selectRootNode = function () {
          this.selectedNode = this.nodes.get(this.map.id + "_node_0");
      };
      /**
       * Delete all nodes.
       */
      Nodes.prototype.clear = function () {
          this.nodes.clear();
      };
      /**
       * Return the siblings of a node.
       * @param {Node} node
       * @returns {Array<Node>} siblings
       */
      Nodes.prototype.getSiblings = function (node) {
          if (!node.isRoot()) {
              var parentChildren = this.getChildren(node.parent);
              if (parentChildren.length > 1) {
                  parentChildren.splice(parentChildren.indexOf(node), 1);
                  return parentChildren;
              }
              else {
                  return [];
              }
          }
          else {
              return [];
          }
      };
      /**
       * Return the appropriate coordinates of the node.
       * @param {Node} node
       * @returns {Coordinates} coordinates
       */
      Nodes.prototype.calculateCoordinates = function (node) {
          var coordinates = {
              x: node.parent.coordinates.x,
              y: node.parent.coordinates.y
          }, siblings = this.getSiblings(node);
          if (node.parent.isRoot()) {
              var rightNodes = [], leftNodes = [];
              for (var _i = 0, siblings_1 = siblings; _i < siblings_1.length; _i++) {
                  var sibling = siblings_1[_i];
                  this.getOrientation(sibling) ? leftNodes.push(sibling) : rightNodes.push(sibling);
              }
              if (leftNodes.length <= rightNodes.length) {
                  coordinates.x -= 200;
                  siblings = leftNodes;
              }
              else {
                  coordinates.x += 200;
                  siblings = rightNodes;
              }
          }
          else {
              if (this.getOrientation(node.parent)) {
                  coordinates.x -= 200;
              }
              else {
                  coordinates.x += 200;
              }
          }
          if (siblings.length > 0) {
              var lowerNode = this.getLowerNode(siblings);
              coordinates.y = lowerNode.coordinates.y + 60;
          }
          else {
              coordinates.y -= 120;
          }
          return coordinates;
      };
      /**
       * Return the lower node of a list of nodes.
       * @param {Node[]} nodes
       * @returns {Node} lowerNode
       */
      Nodes.prototype.getLowerNode = function (nodes) {
          if (nodes === void 0) { nodes = this.nodes.values(); }
          if (nodes.length > 0) {
              var tmp = nodes[0].coordinates.y, lowerNode = nodes[0];
              for (var _i = 0, nodes_1 = nodes; _i < nodes_1.length; _i++) {
                  var node = nodes_1[_i];
                  if (node.coordinates.y > tmp) {
                      tmp = node.coordinates.y;
                      lowerNode = node;
                  }
              }
              return lowerNode;
          }
      };
      /**
       * Move the node selection on the level of the current node (true: up).
       * @param {boolean} direction
       */
      Nodes.prototype.moveSelectionOnLevel = function (direction) {
          var _this = this;
          if (!this.selectedNode.isRoot()) {
              var siblings = this.getSiblings(this.selectedNode).filter(function (node) {
                  return direction === node.coordinates.y < _this.selectedNode.coordinates.y;
              });
              if (this.selectedNode.parent.isRoot()) {
                  siblings = siblings.filter(function (node) {
                      return _this.getOrientation(node) === _this.getOrientation(_this.selectedNode);
                  });
              }
              if (siblings.length > 0) {
                  var closerNode = siblings[0], tmp = Math.abs(siblings[0].coordinates.y - this.selectedNode.coordinates.y);
                  for (var _i = 0, siblings_2 = siblings; _i < siblings_2.length; _i++) {
                      var node = siblings_2[_i];
                      var distance = Math.abs(node.coordinates.y - this.selectedNode.coordinates.y);
                      if (distance < tmp) {
                          tmp = distance;
                          closerNode = node;
                      }
                  }
                  this.selectNode(closerNode.id);
              }
          }
      };
      /**
       * Move the node selection in a child node or in the parent node (true: left)
       * @param {boolean} direction
       */
      Nodes.prototype.moveSelectionOnBranch = function (direction) {
          var _this = this;
          if ((this.getOrientation(this.selectedNode) === false && direction) ||
              (this.getOrientation(this.selectedNode) === true && !direction)) {
              this.selectNode(this.selectedNode.parent.id);
          }
          else {
              var children = this.getChildren(this.selectedNode);
              if (this.getOrientation(this.selectedNode) === undefined) {
                  // The selected node is the root
                  children = children.filter(function (node) {
                      return _this.getOrientation(node) === direction;
                  });
              }
              var lowerNode = this.getLowerNode(children);
              if (children.length > 0) {
                  this.selectNode(lowerNode.id);
              }
          }
      };
      return Nodes;
  }());

  /**
   * Manage map image exports.
   */
  var Export = /** @class */ (function () {
      /**
       * Get the associated map instance.
       * @param {Map} map
       */
      function Export(map) {
          var _this = this;
          /**
           * Return the snapshot (json) of the current map.
           * @returns {MapSnapshot} json
           */
          this.asJSON = function () {
              var snapshot = _this.map.history.current();
              _this.map.events.call(Event.exportJSON);
              return Utils.cloneObject(snapshot);
          };
          /**
           * Return the image data URI in the callback function.
           * @param {Function} callback
           * @param {string} type
           */
          this.asImage = function (callback, type) {
              if (typeof callback !== "function") {
                  Log.error("The first parameter must be a function", "type");
              }
              if (type && typeof type !== "string") {
                  Log.error("The second optional parameter must be a string", "type");
              }
              _this.map.nodes.deselectNode();
              _this.dataURI(function (url) {
                  var image = new Image();
                  image.src = url;
                  image.onload = function () {
                      var canvas = document.createElement("canvas"), context = canvas.getContext("2d");
                      canvas.width = image.width;
                      canvas.height = image.height;
                      context.drawImage(image, 0, 0);
                      context.globalCompositeOperation = "destination-over";
                      context.fillStyle = "#ffffff";
                      context.fillRect(0, 0, canvas.width, canvas.height);
                      if (typeof type === "string") {
                          type = "image/" + type;
                      }
                      callback(canvas.toDataURL(type));
                      _this.map.events.call(Event.exportImage);
                  };
                  image.onerror = function () {
                      Log.error("The image has not been loaded correctly");
                  };
              });
          };
          this.map = map;
      }
      /**
       * Convert the mind map svg in the data URI.
       * @param {Function} callback
       */
      Export.prototype.dataURI = function (callback) {
          var element = this.map.dom.g.node(), clone = element.cloneNode(true), svg = document.createElementNS("http://www.w3.org/2000/svg", "svg"), box = element.getBBox(), css = Utils.cssRules(element), xmlns = "http://www.w3.org/2000/xmlns/", padding = 15, x = box.x - padding, y = box.y - padding, w = box.width + padding * 2, h = box.height + padding * 2;
          svg.setAttributeNS(xmlns, "xmlns", "http://www.w3.org/2000/svg");
          svg.setAttributeNS(xmlns, "xmlns:xlink", "http://www.w3.org/1999/xlink");
          svg.setAttribute("version", "1.1");
          svg.setAttribute("width", w);
          svg.setAttribute("height", h);
          svg.setAttribute("viewBox", [x, y, w, h].join(" "));
          // If there is css, insert it
          if (css !== "") {
              var style = document.createElement("style"), defs = document.createElement("defs");
              style.setAttribute("type", "text/css");
              style.innerHTML = "<![CDATA[\n" + css + "\n]]>";
              defs.appendChild(style);
              svg.appendChild(defs);
          }
          clone.setAttribute("transform", "translate(0,0)");
          svg.appendChild(clone);
          this.convertImages(clone, function () {
              var xmls = new XMLSerializer(), reader = new FileReader();
              var blob = new Blob([
                  xmls.serializeToString(svg)
              ], {
                  type: "image/svg+xml"
              });
              reader.readAsDataURL(blob);
              reader.onloadend = function () {
                  callback(reader.result);
              };
          });
      };
      /**
       * If there are images in the map convert their href in dataURI.
       * @param {HTMLElement} element
       * @param {Function} callback
       */
      Export.prototype.convertImages = function (element, callback) {
          var images = element.querySelectorAll("image"), counter = images.length;
          if (counter > 0) {
              var _loop_1 = function (image) {
                  var canvas = document.createElement("canvas"), ctx = canvas.getContext("2d"), img = new Image(), href = image.getAttribute("href");
                  img.crossOrigin = "Anonymous";
                  img.src = href;
                  img.onload = function () {
                      canvas.width = img.width;
                      canvas.height = img.height;
                      ctx.drawImage(img, 0, 0);
                      image.setAttribute("href", canvas.toDataURL("image/png"));
                      counter--;
                      if (counter === 0) {
                          callback();
                      }
                  };
                  img.onerror = function () {
                      counter--;
                      if (counter === 0) {
                          callback();
                      }
                  };
              };
              for (var _i = 0, _a = images; _i < _a.length; _i++) {
                  var image = _a[_i];
                  _loop_1(image);
              }
          }
          else {
              callback();
          }
      };
      return Export;
  }());

  /**
   * Manage the drag events of the nodes.
   */
  var CopyPaste = /** @class */ (function () {
      /**
       * Get the associated map instance.
       * @param {Map} map
       */
      function CopyPaste(map) {
          var _this = this;
          /**
           * Copy the node with the id passed as parameter or
           * the selected node in the mmp clipboard.
           * @param {string} id
           */
          this.copy = function (id) {
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.map.nodes.getNode(id) : _this.map.nodes.getSelectedNode();
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              if (!node.isRoot()) {
                  _this.copiedNodes = [_this.map.nodes.getNodeProperties(node, false)];
                  _this.map.nodes.getDescendants(node).forEach(function (node) {
                      _this.copiedNodes.push(_this.map.nodes.getNodeProperties(node, false));
                  });
              }
              else {
                  Log.error("The root node can not be copied");
              }
          };
          /**
           * Remove and copy the node with the id passed as parameter or
           * the selected node in the mmp clipboard.
           * @param {string} id
           */
          this.cut = function (id) {
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.map.nodes.getNode(id) : _this.map.nodes.getSelectedNode();
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              if (!node.isRoot()) {
                  _this.copiedNodes = [_this.map.nodes.getNodeProperties(node, false)];
                  _this.map.nodes.getDescendants(node).forEach(function (node) {
                      _this.copiedNodes.push(_this.map.nodes.getNodeProperties(node, false));
                  });
                  _this.map.nodes.removeNode(node.id);
              }
              else {
                  Log.error("The root node can not be cut");
              }
          };
          /**
           * If there are nodes in the mmp clipboard paste them in the map as blog
           * of the node with the passed as parameter or of the selected node.
           * @param {string} id
           */
          this.paste = function (id) {
              if (_this.copiedNodes === undefined) {
                  Log.error("There are not nodes in the mmp clipboard");
              }
              if (id && typeof id !== "string") {
                  Log.error("The node id must be a string", "type");
              }
              var node = id ? _this.map.nodes.getNode(id) : _this.map.nodes.getSelectedNode();
              if (node === undefined) {
                  Log.error("There are no nodes with id \"" + id + "\"");
              }
              var rootNode = _this.map.nodes.getRoot();
              var addNodes = function (nodeProperties, newParentNode) {
                  var coordinates;
                  if (nodeProperties.id !== _this.copiedNodes[0].id) {
                      coordinates = { x: 0, y: 0 };
                      var oldParentNode = _this.copiedNodes.find(function (np) {
                          return np.id === nodeProperties.parent;
                      });
                      var dx = oldParentNode.coordinates.x - nodeProperties.coordinates.x;
                      var dy = oldParentNode.coordinates.y - nodeProperties.coordinates.y;
                      var newParentOrientation = _this.map.nodes.getOrientation(newParentNode);
                      var oldParentOrientation = oldParentNode.coordinates.x < rootNode.coordinates.x;
                      if (oldParentOrientation !== newParentOrientation) {
                          dx = -dx;
                      }
                      coordinates.x = newParentNode.coordinates.x - dx;
                      coordinates.y = newParentNode.coordinates.y - dy;
                      coordinates = _this.map.nodes.fixCoordinates(coordinates, true);
                  }
                  var nodePropertiesCopy = Utils.cloneObject(nodeProperties);
                  _this.map.nodes.addNode({
                      name: nodePropertiesCopy.name,
                      coordinates: coordinates,
                      image: nodePropertiesCopy.image,
                      colors: nodePropertiesCopy.colors,
                      font: nodePropertiesCopy.font,
                      locked: nodePropertiesCopy.locked
                  }, newParentNode.id);
                  var children = _this.copiedNodes.filter(function (np) {
                      return np.parent === nodeProperties.id;
                  });
                  // If there are blog add them.
                  if (children.length > 0) {
                      var nodes = _this.map.nodes.getNodes();
                      newParentNode = nodes[nodes.length - 1];
                      children.forEach(function (np) {
                          addNodes(np, newParentNode);
                      });
                  }
              };
              addNodes(_this.copiedNodes[0], node);
          };
          this.map = map;
      }
      return CopyPaste;
  }());

  /**
   * Initialize all handlers and return a mmp object.
   */
  var Map = /** @class */ (function () {
      /**
       * Create all handler instances, set some map behaviors and return a mmp instance.
       * @param {string} id
       * @param {OptionParameters} options
       * @returns {MmpInstance} mmpInstance
       */
      function Map(id, options) {
          var _this = this;
          /**
           * Remove permanently mmp instance.
           */
          this.remove = function () {
              _this.dom.svg.remove();
              var props = Object.keys(_this.instance);
              for (var i = 0; i < props.length; i++) {
                  delete _this.instance[props[i]];
              }
          };
          this.id = id;
          this.dom = {};
          this.events = new Events();
          this.options = new Options(options, this);
          this.zoom = new Zoom(this);
          this.history = new History(this);
          this.drag = new Drag(this);
          this.draw = new Draw(this);
          this.nodes = new Nodes(this);
          this.export = new Export(this);
          this.copyPaste = new CopyPaste(this);
          this.draw.create();
          if (this.options.centerOnResize === true) {
              d3.select(window).on("resize." + this.id, function () {
                  _this.zoom.center();
              });
          }
          if (this.options.zoom === true) {
              this.dom.svg.call(this.zoom.getZoomBehavior());
          }
          this.nodes.addRootNode();
          this.history.save();
          return this.createMmpInstance();
      }
      /**
       * Return a mmp instance with all mmp library functions.
       * @return {MmpInstance} mmpInstance
       */
      Map.prototype.createMmpInstance = function () {
          return this.instance = {
              on: this.events.on,
              remove: this.remove,
              new: this.history.new,
              updateOptions: this.options.update,
              exportAsJSON: this.export.asJSON,
              exportAsImage: this.export.asImage,
              history: this.history.getHistory,
              undo: this.history.undo,
              redo: this.history.redo,
              zoomIn: this.zoom.zoomIn,
              zoomOut: this.zoom.zoomOut,
              center: this.zoom.center,
              addNode: this.nodes.addNode,
              selectNode: this.nodes.selectNode,
              editNode: this.nodes.editNode,
              deselectNode: this.nodes.deselectNode,
              nodeChildren: this.nodes.nodeChildren,
              updateNode: this.nodes.updateNode,
              removeNode: this.nodes.removeNode,
              copyNode: this.copyPaste.copy,
              cutNode: this.copyPaste.cut,
              pasteNode: this.copyPaste.paste
          };
      };
      return Map;
  }());

  /**
   * The version of the library
   */
  var version$1 = version;
  /**
   * Return a mmp object with all mmp functions.
   * @param {string} id
   * @param {OptionParameters} options
   * @returns {Map}
   */
  function create(id, options) {
      return new Map(id, options);
  }

  exports.version = version$1;
  exports.create = create;

  Object.defineProperty(exports, '__esModule', { value: true });

})));
