from heapq import *
from heuristic import manhattan_state
from grid import get_grid_size, find_zero, grid_to_str

def create_node(grid, strparent, g, m):
    node = {}
    node["grid"] = grid
    node["h"] = manhattan_state(grid)
    node["g"] = g if strparent is 'start' else g + 1
    node["f"] = node["g"] + node["h"]
    node["parent"] = strparent
    node["move"] = m
    node["pos0"] = find_zero(grid)
    return node

def create_child(node):
    children = []
    size = len(node["grid"]) - 1
    strnode = grid_to_str(node["grid"])
    x0 = node["pos0"][0]
    y0 = node["pos0"][1]
    g = node["g"]
    if node["pos0"][0] > 0 and node["move"] != 'l':
        tmp = node["grid"][y0][x0 - 1]
        tmpgrid = node["grid"]
        tmpgrid[y0][x0] = tmp
        tmpgrid[y0][x0 - 1] = 0
        children = create_node(tmpgrid, strnode, g, 'r')
    if node["pos0"][0] < size and node["move"] != 'r':
        tmp = node["grid"][y0][x0 + 1]
        tmpgrid = node["grid"]
        tmpgrid[y0][x0] = tmp
        tmpgrid[y0][x0 + 1] = 0
        children = create_node(tmpgrid, strnode, g, 'l')
    if node["pos0"][1] > 0 and node["move"] != 't':
        tmp = node["grid"][y0 - 1][x0]
        tmpgrid = node["grid"]
        tmpgrid[y0][x0] = tmp
        tmpgrid[y0 - 1][x0] = 0
        children = create_node(tmpgrid, strnode, g, 'b')
    if node["pos0"][1] < size and node["move"] != 'b':
        tmp = node["grid"][y0 + 1][x0]
        tmpgrid = node["grid"]
        tmpgrid[y0][x0] = tmp
        tmpgrid[y0 + 1][x0] = 0
        children = create_node(tmpgrid, strnode, g, 't')
    return children

def convert_dict(dict):
    dictlist = []
    temp = []
    for key, value in dict.iteritems():
        temp = [key,value]
        dictlist.append(temp)
    return dictlist

def a_star(startnode):
    openlist = dict.items(startnode)
    closedlist = []
    #print(openlist)
    # PREMIER ARGUMENT STARTNODE OU OPENLIST ?
    #heapify(openlist)
    heappush(openlist, startnode["f"])
    while openlist:   
        current = heappop(openlist)
        print(current)






# f = G + H
# greedy : ne verifie pas les parents, prend le f le plus petit et continue.
# uniform : remonte et verifie la valeur de f + celle de chaque parent jusqu'a trouver la plus petite.

