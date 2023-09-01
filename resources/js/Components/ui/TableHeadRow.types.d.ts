
export type ColumnType = '' | 'actions' | string

export interface IColumn{
    title?: string
    imageType?: boolean
    href?: string
    src?: string
    itemKey?: string
}


export type TColumns = Array<IColumn>
