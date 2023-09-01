export type BodyColumnTypes = '' | 'actions' | 'link' | 'avatar'


export interface TBodyColumn {
    title?: string
    imageType?: boolean
    href?: string
    src?: string
    itemKey?: string
}

export type TBodyColumns = Array<TBodyColumn>
