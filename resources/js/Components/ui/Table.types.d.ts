import {TColumns} from "./TableHeadRow.types";
import {TBodyColumns} from "./TableBodyRow.types";

export type TableColumns = TColumns|TBodyColumns;
export type TAvailableSorting = undefined | 'asc'| 'desc';
